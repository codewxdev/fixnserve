<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Fraud\Models\GeoVelocityAlert;
use App\Domains\Fraud\Models\IpBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SessionRiskService
{
    // ═══════════════════════════════════════════
    // MAIN METHOD - Called by Middleware
    // ═══════════════════════════════════════════

    public function evaluateSession(Request $request): void
    {
        try {
            $ip = $request->ip();
            $userAgent = $request->userAgent();
            $fingerprint = $request->header('X-Device-ID')
                        ?? $request->fingerprint
                        ?? null;
            $userId = auth()->id();

            // ✅ Get current active session
            $session = DB::table('user_sessions')
                ->where('user_id', $userId)
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->latest('last_activity_at')
                ->first();

            if (! $session) {
                return;
            }

            $riskScore = 0;
            $indicators = [];

            // ✅ Get location from headers FIRST
            // then fallback to IP API
            $locationData = $this->getLocationData($request, $ip);

            \Log::info('📍 Location data', $locationData);

            // CHECK 1: New Device
            if ($this->isNewDevice($userId, $fingerprint)) {
                $indicators[] = 'New Device Detected';
                $riskScore += 30;
            }

            // CHECK 2: IP Reputation
            if ($locationData['is_vpn']) {
                $indicators[] = 'VPN Detected';
                $riskScore += 20;
            }

            if ($locationData['is_datacenter']) {
                $indicators[] = 'Data Center IP';
                $riskScore += 25;
            }

            if ($locationData['is_tor']) {
                $indicators[] = 'TOR Exit Node';
                $riskScore += 40;
            }

            // CHECK 3: Missing User Agent
            if (empty($userAgent)) {
                $indicators[] = 'Missing User-Agent';
                $riskScore += 35;
            }

            // CHECK 4: Brute Force
            if ($this->detectBruteForce($ip)) {
                $indicators[] = 'Brute Force Try';
                $riskScore += 40;
            }

            // CHECK 5: ATO
            if ($this->detectATO($userId, $ip, $fingerprint)) {
                $indicators[] = 'ATO Suspected';
                $riskScore += 40;
            }

            // CHECK 6: Off Hours
            if ($this->isOffHours()) {
                $indicators[] = 'Off-hours Login';
                $riskScore += 15;
            }

            // CHECK 7: High Velocity
            if ($this->detectHighVelocity($userId)) {
                $indicators[] = 'High Request Velocity (API)';
                $riskScore += 30;
            }

            // ✅ UPDATE session with location
            $finalScore = min(100, $riskScore);

            DB::table('user_sessions')
                ->where('id', $session->id)
                ->update([
                    'risk_score' => $finalScore,
                    'ip_address' => $ip,
                    'country' => $locationData['country'],
                    'latitude' => $locationData['lat'],
                    'longitude' => $locationData['lng'],
                    'location' => $locationData['city'],
                    'last_activity_at' => now(),
                ]);

            // ✅ CHECK 8: Geo Velocity AFTER updating session
            $this->checkGeoVelocity(
                $userId,
                $locationData['lat'],
                $locationData['lng'],
                $locationData['city'],
                $locationData['country'],
                $session  // pass OLD session (before update)
            );

            // AUTO ACTION
            $this->applyAutoAction(
                $session->id,
                $userId,
                $finalScore,
                $indicators,
                $ip
            );

            \Log::info('✅ Session evaluated', [
                'user_id' => $userId,
                'score' => $finalScore,
                'indicators' => $indicators,
                'location' => $locationData,
            ]);

        } catch (\Exception $e) {
            \Log::error('❌ Session evaluation error: '.$e->getMessage());
        }
    }

    // ✅ NEW METHOD - Get location from headers OR IP API
    private function getLocationData(Request $request, string $ip): array
    {
        // ✅ First: Check request headers (sent by mobile/web app)
        $headerLat = $request->header('X-Latitude');
        $headerLng = $request->header('X-Longitude');
        $headerCity = $request->header('X-Location');
        $headerCountry = $request->header('X-Country');

        \Log::info('📍 Headers received', [
            'X-Latitude' => $headerLat,
            'X-Longitude' => $headerLng,
            'X-Location' => $headerCity,
            'X-Country' => $headerCountry,
        ]);

        // ✅ If headers have location - use them
        if ($headerLat && $headerLng) {
            return [
                'lat' => (float) $headerLat,
                'lng' => (float) $headerLng,
                'city' => $headerCity ?? 'Unknown',
                'country' => $headerCountry ?? 'Unknown',
                'is_vpn' => false,
                'is_datacenter' => false,
                'is_tor' => false,
                'source' => 'header', // for debugging
            ];
        }

        // ✅ Fallback: IP API (only for non-localhost)
        if (! in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return $this->checkIpReputation($ip);
        }

        // ✅ Localhost fallback
        return [
            'lat' => null,
            'lng' => null,
            'city' => 'Unknown',
            'country' => 'Unknown',
            'is_vpn' => false,
            'is_datacenter' => false,
            'is_tor' => false,
            'source' => 'localhost',
        ];
    }

    // ═══════════════════════════════════════════
    // CHECK METHODS
    // ═══════════════════════════════════════════

    // ✅ New Device Check
    private function isNewDevice(int $userId, ?string $fingerprint): bool
    {
        if (! $fingerprint) {
            return false;
        }

        return ! DB::table('devices')
            ->where('user_id', $userId)
            ->where('fingerprint', $fingerprint)
            ->exists();
    }

    // ✅ IP Reputation Check
    public function checkIpReputation(string $ip): array
    {
        return Cache::remember("ip_rep:{$ip}", 3600, function () use ($ip) {
            try {
                Log::info('🌐 Calling IP API for: '.$ip);

                $response = Http::timeout(5)
                    ->get("http://ip-api.com/json/{$ip}", [
                        'fields' => 'status,country,city,lat,lon,proxy,hosting',
                    ]);

                Log::info('🌐 IP API response', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                if (! $response->successful()) {
                    throw new \Exception('IP API failed: '.$response->status());
                }

                $data = $response->json();

                return [
                    'is_vpn' => (bool) ($data['proxy'] ?? false),
                    'is_datacenter' => (bool) ($data['hosting'] ?? false),
                    'is_tor' => false,
                    'country' => $data['country'] ?? 'Unknown',
                    'city' => $data['city'] ?? 'Unknown',
                    'lat' => $data['lat'] ?? null,
                    'lng' => $data['lon'] ?? null,
                    'source' => 'ip_api',
                ];

            } catch (\Exception $e) {
                Log::error('❌ IP API error: '.$e->getMessage());

                return [
                    'is_vpn' => false,
                    'is_datacenter' => false,
                    'is_tor' => false,
                    'country' => 'Unknown',
                    'city' => 'Unknown',
                    'lat' => null,
                    'lng' => null,
                    'source' => 'failed',
                ];
            }
        });
    }

    // ✅ ATO Detection
    private function detectATO(
        int $userId,
        string $ip,
        ?string $fingerprint
    ): bool {
        if (! $fingerprint) {
            return false;
        }

        $knownDevice = DB::table('devices')
            ->where('user_id', $userId)
            ->where('fingerprint', $fingerprint)
            ->exists();

        $knownIp = DB::table('user_sessions')
            ->where('user_id', $userId)
            ->where('ip_address', $ip)
            ->exists();

        return ! $knownDevice && ! $knownIp;
    }

    // ✅ Brute Force Detection
    private function detectBruteForce(string $ip): bool
    {
        $key = "brute_force:{$ip}";
        $count = Cache::get($key, 0);

        return $count >= 10;
    }

    public function incrementBruteForce(string $ip): void
    {
        $key = "brute_force:{$ip}";
        $count = Cache::increment($key);
        if ($count === 1) {
            Cache::expire($key, 3600);
        }
    }

    // ✅ High Velocity Detection
    private function detectHighVelocity(int $userId): bool
    {
        $key = "velocity:{$userId}";
        $count = Cache::get($key, 0);

        return $count >= 100; // 100 requests per minute
    }

    public function incrementVelocity(int $userId): void
    {
        $key = "velocity:{$userId}";
        $count = Cache::increment($key);
        if ($count === 1) {
            Cache::expire($key, 60);
        }
    }

    // ✅ Off Hours Check
    private function isOffHours(): bool
    {
        $hour = now()->hour;

        return $hour >= 0 && $hour <= 5;
    }

    // ✅ Geo Velocity Check
    private function checkGeoVelocity(
        int $userId,
        ?float $currentLat,
        ?float $currentLng,
        string $currentCity,
        string $currentCountry,
        object $currentSession
    ): void {
        // dd($userId, $currentLat, $currentLng, $currentCity, $currentCountry, $currentSession);
        if (! $currentLat || ! $currentLng) {
            return;
        }

        // Get previous session location
        $lastSession = DB::table('user_sessions')
            ->where('user_id', $userId)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->whereNull('revoked_at')
            ->where('id', '!=', $currentSession->id)
            ->orderByDesc('last_activity_at')
            ->first();

        if (! $lastSession) {
            return;
        }
        // dd($lastSession, $currentLat, $currentLng);

        $distance = $this->haversineDistance(
            $lastSession->latitude,
            $lastSession->longitude,
            $currentLat,
            $currentLng
        );

        $timeDiff = now()->diffInMinutes($lastSession->last_activity_at);

        // Impossible: >500km in <60 mins
        $isImpossible = $distance > 500 && $timeDiff < 60;

        if ($isImpossible || $distance > 1000) {
            GeoVelocityAlert::create([
                'user_id' => $userId,
                'from_city' => $lastSession->location ?? 'Unknown',
                'from_country' => $lastSession->country ?? 'Unknown',
                'to_city' => $currentCity,
                'to_country' => $currentCountry,
                'from_lat' => $lastSession->latitude,
                'from_lng' => $lastSession->longitude,
                'to_lat' => $currentLat,
                'to_lng' => $currentLng,
                'time_diff_minutes' => $timeDiff,
                'distance_km' => round($distance, 2),
                'is_impossible' => $isImpossible,
                'risk_level' => $isImpossible ? 'critical' : 'high',
            ]);
        }
    }

    // ✅ Haversine Distance Formula
    private function haversineDistance(
        float $lat1, float $lng1,
        float $lat2, float $lng2
    ): float {

        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng / 2) * sin($dLng / 2);

        return $earthRadius * 2 * atan2(sqrt($a), sqrt(1 - $a));
    }

    // ═══════════════════════════════════════════
    // AUTO ACTION METHOD
    // ═══════════════════════════════════════════

    private function applyAutoAction(
        int $sessionId,
        int $userId,
        int $riskScore,
        array $indicators,
        string $ip
    ): void {

        match (true) {

            // 🔴 Critical: Terminate + Block IP
            $riskScore >= 90 => $this->handleCritical(
                $sessionId, $userId, $ip, $indicators
            ),

            // 🟠 High: Temporary Lock
            $riskScore >= 70 => $this->handleHighRisk($userId),

            // 🟡 Medium: Step-up Auth
            $riskScore >= 50 => $this->handleMediumRisk($sessionId, $userId),

            // 🟢 Low: Just monitoring
            default => null,
        };
    }

    private function handleCritical(
        int $sessionId,
        int $userId,
        string $ip,
        array $indicators
    ): void {

        // Terminate session
        DB::table('user_sessions')
            ->where('id', $sessionId)
            ->update(['revoked_at' => now()]);

        // Block IP if bot signals
        $botSignals = ['Missing User-Agent', 'Brute Force Try', 'High Request Velocity (API)'];
        if (! empty(array_intersect($botSignals, $indicators))) {
            IpBlock::updateOrCreate(
                ['ip_address' => $ip],
                [
                    'type' => 'bot',
                    'reason' => 'Auto: Bot/Brute force detected',
                    'is_active' => true,
                    'block_count' => DB::raw('block_count + 1'),
                ]
            );
        }

        Log::warning('🔴 Critical session terminated', [
            'user_id' => $userId,
            'session_id' => $sessionId,
            'ip' => $ip,
        ]);
    }

    private function handleHighRisk(int $userId): void
    {
        Cache::put(
            "session_locked:{$userId}",
            true,
            now()->addHours(1)
        );

        Log::warning('🟠 Session locked', ['user_id' => $userId]);
    }

    private function handleMediumRisk(int $sessionId, int $userId): void
    {
        // Set mfa_verified = 0 in user_sessions
        DB::table('user_sessions')
            ->where('id', $sessionId)
            ->update(['mfa_verified' => 0]);

        Cache::put(
            "stepup_required:{$userId}",
            true,
            now()->addMinutes(30)
        );

        Log::info('🟡 Step-up auth required', ['user_id' => $userId]);
    }

    // ═══════════════════════════════════════════
    // PUBLIC ACTION METHODS (Admin Use)
    // ═══════════════════════════════════════════

    public function terminateSession(int $sessionId): void
    {
        DB::table('user_sessions')
            ->where('id', $sessionId)
            ->update(['revoked_at' => now()]);
    }

    public function lockSession(int $userId): void
    {
        Cache::put("session_locked:{$userId}", true, now()->addHours(1));
    }

    public function unlockSession(int $userId): void
    {
        // dd("Unlocking session for user_id: {$userId}");
        Cache::forget("session_locked:{$userId}");
    }

    public function triggerStepupAuth(int $sessionId, int $userId): void
    {
        DB::table('user_sessions')
            ->where('id', $sessionId)
            ->update(['mfa_verified' => 0]);

        Cache::put("stepup_required:{$userId}", true, now()->addMinutes(30));
    }

    public function isIpBlocked(string $ip): bool
    {
        return IpBlock::isBlocked($ip);
    }

    // ═══════════════════════════════════════════
    // DASHBOARD STATS
    // ═══════════════════════════════════════════

    public function getDashboardStats(): array
    {
        return [
            'sessions' => [
                'total_active' => DB::table('user_sessions')
                    ->whereNull('revoked_at')
                    ->where('expires_at', '>', now())
                    ->count(),

                'suspicious' => DB::table('user_sessions')
                    ->whereNull('revoked_at')
                    ->where('risk_score', '>=', 50)
                    ->where('expires_at', '>', now())
                    ->count(),

                'high_risk' => DB::table('user_sessions')
                    ->whereNull('revoked_at')
                    ->where('risk_score', '>=', 70)
                    ->where('expires_at', '>', now())
                    ->count(),

                'terminated_today' => DB::table('user_sessions')
                    ->whereNotNull('revoked_at')
                    ->whereDate('revoked_at', today())
                    ->count(),
            ],

            'bot_threats' => [
                'active_ip_blocks' => IpBlock::active()->count(),
                'vpn_blocks' => IpBlock::active()->byType('vpn')->count(),
                'tor_detected' => IpBlock::active()->byType('tor')->count(),
                'bot_blocks' => IpBlock::active()->byType('bot')->count(),
            ],

            'geo_velocity' => [
                'open_alerts' => GeoVelocityAlert::open()->count(),
                'critical_alerts' => GeoVelocityAlert::open()->critical()->count(),
            ],
        ];
    }
}

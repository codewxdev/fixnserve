<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\RiskScoringService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class DetectGeoInconsistency
{
    public function __construct(
        protected RiskScoringService $riskService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! auth()->check()) {
            return $response;
        }

        $currentIp = $request->ip();
        $userId = auth()->id();
        $cacheKey = "user:{$userId}:last_ip";
        $lastIp = Cache::get($cacheKey);

        if ($lastIp && $lastIp !== $currentIp) {
            // ✅ IP changed = possible geo mismatch
            $currentCountry = $this->getCountryFromIp($currentIp);
            $lastCountry = $this->getCountryFromIp($lastIp);

            if ($currentCountry !== $lastCountry) {
                $entityInfo = $this->getEntityInfo();

                $this->riskService->processEvent(
                    entityType: $entityInfo['type'],
                    entityId: $entityInfo['id'],
                    eventType: 'geo_mismatch',
                    eventData: [
                        'last_ip' => $lastIp,
                        'current_ip' => $currentIp,
                        'last_country' => $lastCountry,
                        'current_country' => $currentCountry,
                    ]
                );
            }
        }

        // ✅ Update last IP
        Cache::put($cacheKey, $currentIp, now()->addDays(7));

        return $response;
    }

    private function getCountryFromIp(string $ip): string
    {
        // Use your existing geo service
        return Cache::remember("ip_country:{$ip}", 3600, function () use ($ip) {
            // Simple IP to country (use MaxMind or ip-api.com)
            try {
                $response = \Http::get("http://ip-api.com/json/{$ip}");

                return $response->json('country') ?? 'Unknown';
            } catch (\Exception $e) {
                return 'Unknown';
            }
        });
    }

    private function getEntityInfo(): array
    {
        $user = auth()->user();
        $entityType = match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            default => 'user',
        };

        return ['type' => $entityType, 'id' => $user->id];
    }
}

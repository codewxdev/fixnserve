<?php

namespace App\Domains\Fraud\Controllers\Api;

use App\Domains\Fraud\Models\GeoVelocityAlert;
use App\Domains\Fraud\Models\IpBlock;
use App\Domains\Fraud\Services\SessionRiskService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SessionIdentityRiskController extends BaseApiController
{
    public function __construct(
        protected SessionRiskService $sessionRiskService
    ) {}

    // ═══════════════════════════════════════════
    // 1. DASHBOARD
    // ═══════════════════════════════════════════

    public function dashboard()
    {
        return $this->success(
            $this->sessionRiskService->getDashboardStats(),
            'session_dashboard_fetched'
        );
    }

    // ═══════════════════════════════════════════
    // 2. LIVE SESSIONS
    // ═══════════════════════════════════════════

    public function liveSessions(Request $request)
    {
        $request->validate([
            'risk_level' => 'nullable|in:all,suspicious,high,critical',
            'status' => 'nullable|in:active,revoked',
        ]);

        $query = DB::table('user_sessions')
            ->leftJoin('users', 'user_sessions.user_id', '=', 'users.id')
            ->whereNull('user_sessions.revoked_at')
            ->where('user_sessions.expires_at', '>', now())
            ->select([
                'user_sessions.id',
                'user_sessions.user_id',
                'users.name as user_name',
                'user_sessions.device',
                'user_sessions.ip_address',
                'user_sessions.country',
                'user_sessions.risk_score',
                'user_sessions.mfa_verified',
                'user_sessions.last_activity_at',
                'user_sessions.created_at',
            ]);

        // Filter by risk level
        match ($request->risk_level) {
            'suspicious' => $query->where('user_sessions.risk_score', '>=', 50),
            'high' => $query->where('user_sessions.risk_score', '>=', 70),
            'critical' => $query->where('user_sessions.risk_score', '>=', 90),
            default => null,
        };

        $sessions = $query
            ->orderByDesc('user_sessions.risk_score')
            ->paginate(20);

        return $this->success($sessions, 'live_sessions_fetched');
    }

    // ═══════════════════════════════════════════
    // 3. SESSION DETAIL
    // ═══════════════════════════════════════════

    public function sessionDetail(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->leftJoin('users', 'user_sessions.user_id', '=', 'users.id')
            ->where('user_sessions.id', $sessionId)
            ->select([
                'user_sessions.*',
                'users.name as user_name',
                'users.email as user_email',
            ])
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        // Get user devices
        $devices = DB::table('devices')
            ->where('user_id', $session->user_id)
            ->get();

        return $this->success([
            'session' => $session,
            'devices' => $devices,
        ], 'session_detail_fetched');
    }

    // ═══════════════════════════════════════════
    // 4. TERMINATE SESSION
    // ═══════════════════════════════════════════

    public function terminateSession(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->where('id', $sessionId)
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        $this->sessionRiskService->terminateSession($sessionId);

        return $this->success(null, 'session_terminated');
    }

    // ═══════════════════════════════════════════
    // 5. PURGE ALL BOT SESSIONS
    // ═══════════════════════════════════════════

    public function purgeBotSessions()
    {
        $count = DB::table('user_sessions')
            ->where('risk_score', '>=', 90)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);

        return $this->success([
            'purged_count' => $count,
            'message' => "{$count} bot sessions terminated",
        ], 'bot_sessions_purged');
    }

    // ═══════════════════════════════════════════
    // 6. TEMPORARY LOCK
    // ═══════════════════════════════════════════

    public function temporaryLock(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->where('id', $sessionId)
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        $this->sessionRiskService->lockSession($session->user_id);

        return $this->success([
            'user_id' => $session->user_id,
            'locked_until' => now()->addHour()->toDateTimeString(),
        ], 'session_locked');
    }

    // ═══════════════════════════════════════════
    // 7. UNLOCK SESSION
    // ═══════════════════════════════════════════

    public function unlockSession(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->where('id', $sessionId)
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        $this->sessionRiskService->unlockSession($session->user_id);

        return $this->success(null, 'session_unlocked');
    }

    // ═══════════════════════════════════════════
    // 8. TRIGGER STEP-UP AUTH
    // ═══════════════════════════════════════════

    public function triggerStepupAuth(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->where('id', $sessionId)
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        $this->sessionRiskService->triggerStepupAuth(
            $sessionId,
            $session->user_id
        );

        return $this->success([
            'user_id' => $session->user_id,
            'message' => 'Step-up auth triggered - awaiting OTP',
        ], 'stepup_auth_triggered');
    }

    // ═══════════════════════════════════════════
    // 9. NOTIFY USER
    // ═══════════════════════════════════════════

    public function notifyUser(int $sessionId)
    {
        $session = DB::table('user_sessions')
            ->where('id', $sessionId)
            ->first();

        if (! $session) {
            return $this->error('session_not_found', 404);
        }

        // Your notification logic here
        Log::info("🔔 Security alert sent to user: {$session->user_id}");

        return $this->success([
            'user_id' => $session->user_id,
            'message' => 'User notified successfully',
        ], 'user_notified');
    }

    // ═══════════════════════════════════════════
    // 10. GET IP BLOCKS
    // ═══════════════════════════════════════════

    public function getIpBlocks(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:vpn,proxy,tor,datacenter,manual,bot',
        ]);

        $blocks = IpBlock::with('blockedBy:id,name')
            ->active()
            ->when($request->type, fn ($q) => $q->byType($request->type))
            ->latest()
            ->paginate(20);

        return $this->success($blocks, 'ip_blocks_fetched');
    }

    // ═══════════════════════════════════════════
    // 11. BLOCK IP
    // ═══════════════════════════════════════════

    public function blockIp(Request $request)
    {
        $validated = $request->validate([
            'ip_address' => 'required|ip',
            'type' => 'required|in:vpn,proxy,tor,datacenter,manual,bot',
            'reason' => 'nullable|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $block = IpBlock::updateOrCreate(
            ['ip_address' => $validated['ip_address']],
            [
                'type' => $validated['type'],
                'reason' => $validated['reason'] ?? 'Manual block',
                'blocked_by' => auth()->id(),
                'expires_at' => $validated['expires_at'] ?? null,
                'is_active' => true,
                'block_count' => DB::raw('block_count + 1'),
            ]
        );

        return $this->success($block, 'ip_blocked', 201);
    }

    // ═══════════════════════════════════════════
    // 12. UNBLOCK IP
    // ═══════════════════════════════════════════

    public function unblockIp(string $ip)
    {
        $block = IpBlock::where('ip_address', $ip)->first();

        if (! $block) {
            return $this->error('ip_not_found', 404);
        }

        $block->update(['is_active' => false]);

        return $this->success(null, 'ip_unblocked');
    }

    // ═══════════════════════════════════════════
    // 13. GEO VELOCITY ALERTS
    // ═══════════════════════════════════════════

    public function geoVelocityAlerts(Request $request)
    {
        $request->validate([
            'risk_level' => 'nullable|in:medium,high,critical',
            'status' => 'nullable|in:open,reviewed,dismissed',
        ]);

        $alerts = GeoVelocityAlert::with('user:id,name,email')
            ->when($request->risk_level, fn ($q) => $q->where('risk_level', $request->risk_level))
            ->when($request->status, fn ($q) => $q->where('status', $request->status), fn ($q) => $q->open())
            ->latest()
            ->paginate(20);

        return $this->success($alerts, 'geo_velocity_alerts_fetched');
    }

    // ═══════════════════════════════════════════
    // 14. DISMISS GEO ALERT
    // ═══════════════════════════════════════════

    public function dismissGeoAlert(GeoVelocityAlert $alert)
    {
        $alert->update(['status' => 'dismissed']);

        return $this->success($alert, 'geo_alert_dismissed');
    }

    // ═══════════════════════════════════════════
    // 15. REVIEW GEO ALERT
    // ═══════════════════════════════════════════

    public function reviewGeoAlert(GeoVelocityAlert $alert)
    {
        $alert->update(['status' => 'reviewed']);

        return $this->success($alert, 'geo_alert_reviewed');
    }
}

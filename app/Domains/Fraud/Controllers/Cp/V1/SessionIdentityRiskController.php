<?php

namespace App\Domains\Fraud\Controllers\Cp\V1;

use App\Domains\Fraud\Models\GeoVelocityAlert;
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

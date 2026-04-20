<?php

namespace App\Domains\Fraud\Middlewares;

use App\Domains\Fraud\Services\SessionRiskService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SessionRiskMiddleware
{
    public function __construct(
        protected SessionRiskService $sessionRiskService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        // ════════════════════════════════
        // GATE 1: IP BLOCKED?
        // ════════════════════════════════
        if ($this->sessionRiskService->isIpBlocked($ip)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Access denied',
                'reason' => 'ip_blocked',
            ], 403);
        }

        if (auth()->check()) {
            $userId = auth()->id();

            // ════════════════════════════════
            // GATE 2: ACCOUNT LOCKED?
            // ════════════════════════════════
            if (Cache::get("session_locked:{$userId}")) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Account temporarily locked',
                    'reason' => 'temporary_lock',
                    'retry_after' => '1 hour',
                ], 423);
            }

            // ════════════════════════════════
            // GATE 3: STEP-UP AUTH REQUIRED?
            // ════════════════════════════════
            $session = DB::table('user_sessions')
                ->where('user_id', $userId)
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->latest('last_activity_at')
                ->first();

            if ($session && ! $session->mfa_verified) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Step-up authentication required',
                    'reason' => 'stepup_auth_required',
                ], 403);
            }

            // ════════════════════════════════
            // VELOCITY COUNTER INCREMENT
            // ════════════════════════════════
            $this->sessionRiskService->incrementVelocity($userId);
        }

        // ════════════════════════════════
        // BRUTE FORCE COUNTER
        // (for unauthenticated requests)
        // ════════════════════════════════
        if (! auth()->check() && $request->is('api/auth/login')) {
            $this->sessionRiskService->incrementBruteForce($ip);
        }

        // ════════════════════════════════
        // REQUEST PROCEED
        // ════════════════════════════════
        $response = $next($request);

        // ════════════════════════════════
        // EVALUATE SESSION AFTER REQUEST
        // Only on success + authenticated
        // ════════════════════════════════
        if (
            auth()->check() &&
            $response->getStatusCode() >= 200 &&
            $response->getStatusCode() < 300
        ) {


            $this->sessionRiskService->evaluateSession($request);
        }

        return $response;
    }
}

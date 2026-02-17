<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\UserSession;
use App\Models\BlacklistedToken;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        try {
            $token = $request->bearerToken();
            $payload = JWTAuth::setToken($token)->getPayload();
            $jti = $payload->get('jti');

            if (
                BlacklistedToken::where('jwt_id', $jti)
                    ->where('expires_at', '>', now())
                    ->exists()
            ) {
                return response()->json([
                    'message' => 'Session revoked',
                ], 401);
            }

            $session = UserSession::where('jwt_id', $jti)
                ->where('is_revoked', false)
                ->first();

            if (! $session) {
                return response()->json([
                    'message' => 'Session invalid or expired',
                ], 401);
            }

            $session->update([
                'last_activity_at' => now(),
            ]);

            return $next($request);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid or expired token',
            ], 401);
        }
    }
}

<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\UserSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class ValidateUserSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {

            $payload = JWTAuth::parseToken()->getPayload();

            $jti = $payload->get('jti');

            $session = UserSession::where('jwt_id', $jti)
                ->where('is_revoked', 0)
                ->whereNull('revoked_at')
                ->where('expires_at', '>', now())
                ->first();

            if (! $session) {

                return response()->json([
                    'error' => 'Session expired or revoked',
                ], 401);

            }

            // Update activity
            $session->update([
                'last_activity_at' => now(),
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}

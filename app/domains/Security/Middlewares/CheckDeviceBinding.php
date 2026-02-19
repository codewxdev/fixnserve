<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\UserSession;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckDeviceBinding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        $jti = $payload->get('jti');

        $session = UserSession::where('jwt_id', $jti)
            ->where('is_revoked', false)
            ->first();

        if (! $session) {
            abort(401, 'Session revoked');
        }

        if ($session->device !== ($request->userAgent() ?? 'Unknown')) {
            // dd('Device mismatch: expected '.$session->device.', got '.($request->userAgent() ?? 'Unknown'));
            abort(401, 'Device mismatch');
        }

        return $next($request);
    }
}

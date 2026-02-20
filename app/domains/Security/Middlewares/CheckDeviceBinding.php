<?php

namespace App\Domains\Security\Middlewares;

use App\Domains\Security\Models\Device;
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
        try {
            $payload = JWTAuth::parseToken()->getPayload();
            $jti = $payload->get('jti');

            $session = UserSession::where('jwt_id', $jti)
                ->where('is_revoked', false)
                ->first();
            if (! $session) {
                abort(401, 'Session revoked');
            }

            // 🔐 Get fingerprint from request
            $fingerprint = $request->header('X-Device-Fingerprint');
            // dd($fingerprint);
            if (! $fingerprint) {
                abort(401, 'Device fingerprint missing');
            }

            $device = Device::where('fingerprint', $fingerprint)
                ->where('user_id', $session->user_id)
                ->first();

            if (! $device) {
                abort(401, 'Device not recognized');
            }

            // 🚨 Compare with session device
            if ($session->device_id !== $device->id) {
                abort(401, 'Device mismatch');
            }

            return $next($request);

        } catch (\Exception $e) {
            abort(401, 'Invalid token');
        }
    }
}

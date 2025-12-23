<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();

            // Check if token has super admin claim
            if (! $payload->get('is_super_admin', false)) {
                return response()->json(['error' => 'Super Admin access required'], 403);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}

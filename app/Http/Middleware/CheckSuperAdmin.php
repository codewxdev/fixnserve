<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth; // Import Auth

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Retrieve token from Bearer Header OR 'token' Cookie
        $token = $request->bearerToken() ?? $request->cookie('token');

        if (! $token) {
            // If request expects HTML (browser), redirect to login
            if ($request->acceptsHtml()) {
                return redirect()->route('login.index');
            }
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // 2. Set the token manually for the library
            JWTAuth::setToken($token);

            // 3. Authenticate the user and get the User object
            if (! $user = JWTAuth::authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }

            // 4. *** CRITICAL FIX *** // Set the authenticated user in Laravel's global Auth guard.
            // This allows Auth::user() to work in your Controller, Views, and 2FA middleware.
            Auth::setUser($user);

            // 5. Check Payload Claims
            $payload = JWTAuth::getPayload();
            if (! $payload->get('is_super_admin', false)) {
                if ($request->acceptsHtml()) {
                    abort(403, 'Super Admin access required');
                }
                return response()->json(['error' => 'Super Admin access required'], 403);
            }

        } catch (\Exception $e) {
            // If token is invalid/expired and it's a browser request, go to login
            if ($request->acceptsHtml()) {
                return redirect()->route('login.index')->withErrors('Session expired, please login again.');
            }
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Try to get the token from the 'token' cookie
        $token = $request->cookie('token');

        if (! $token) {
            // No token found -> Redirect to login
            return redirect()->route('login.index');
        }

        try {
            // 2. Tell JWTAuth to use this specific token
            JWTAuth::setToken($token);

            // 3. Authenticate the user based on the token
            if (! $user = JWTAuth::authenticate()) {
                return redirect()->route('login.index')->withErrors(['error' => 'User not found']);
            }

            // 4. Manually log the user in for this request
            // This makes auth()->user() work in your Controllers and Views
            Auth::setUser($user);

        } catch (\Exception $e) {
            // 5. If token is invalid or expired, redirect to login
            return redirect()->route('login.index')->withErrors(['error' => 'Session expired, please login again.']);
        }

        // 6. Proceed
        return $next($request);
    }
}

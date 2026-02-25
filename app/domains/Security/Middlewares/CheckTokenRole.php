<?php

namespace App\Domains\Security\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckTokenRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {

        $token = JWTAuth::getToken();

        $payload = JWTAuth::setToken($token)->getPayload();
        // dd($payload);
        // $payload = JWTAuth::parseToken()->getPayload();
        // dd($payload); // Debugging line to inspect the token payload
        $tokenRole = $payload->get('role');
        $userRole = auth()->user()->role;

        if ($tokenRole !== $userRole) {
            abort(403, 'Role changed. Re-login required.');
        }

        return $next($request);
    }
}

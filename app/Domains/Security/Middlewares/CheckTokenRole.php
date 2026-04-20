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
        // dd($tokenRole);
        $userRole = auth()->user()->getRoleNames()->first(); // Assuming single role per user

        if ($tokenRole !== $userRole) {
            return response()->json(['error' => 'Role changed. Re-login required.'], 403);
            // abort(403, 'Role changed. Re-login required.');
        }

        return $next($request);
    }
}

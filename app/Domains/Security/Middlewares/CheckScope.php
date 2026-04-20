<?php

namespace App\Domains\Security\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$requiredScopes)
    {
        $payload = JWTAuth::parseToken()->getPayload();
        // dd($payload);
        $tokenScopes = $payload->get('scopes', []);

        foreach ($requiredScopes as $scope) {
            if (in_array($scope, $tokenScopes) || in_array('admin:*', $tokenScopes)) {
                return $next($request);
            }
        }

        abort(403, 'Insufficient token scope');
    }
}

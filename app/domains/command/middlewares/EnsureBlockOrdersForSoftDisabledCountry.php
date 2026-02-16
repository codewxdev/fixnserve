<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBlockOrdersForSoftDisabledCountry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->attributes->get('country_soft_disabled') === true) {
            return response()->json([
                'message' => 'Orders are temporarily disabled in your country',
            ], 403);
        }

        return $next($request);
    }
}

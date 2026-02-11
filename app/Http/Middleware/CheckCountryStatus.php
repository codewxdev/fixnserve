<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCountryStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user || ! $user->country_id) {
            return $next($request); // skip if no user or country
        }

        $country = $user->country; // assuming User has relation to Country

        if (! $country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        if ($country->status === 'hard_disabled') {
            return response()->json(['message' => 'Your country is blocked'], 403);
        }

        if ($country->status === 'soft_disabled') {
            // optionally allow access but prevent certain actions
            // you can set a request attribute
            $request->attributes->set('soft_disabled', true);
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $key = 'emergency_override:admin:'.auth()->id();
        $data = Redis::get($key);

        if (! $data) {
            return $next($request);
        }

        $override = json_decode($data, true);

        // STEP 5.1 — AUTO EXPIRY
        if (now()->greaterThan($override['expires_at'])) {
            Redis::del($key);

            return $next($request);
        }

        // STEP 5.2 — MARK REQUEST
        $request->merge(['emergency_override' => true]);

        return $next($request);
    }
}

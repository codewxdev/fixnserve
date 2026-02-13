<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EmergencyOverrideMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // STEP 1 — Admin must be authenticated
        $admin = auth('Super Admin')->user();

        if (! $admin) {
            return $next($request);
        }

        // STEP 2 — Fetch override session
        $key = 'emergency_override:admin:'.$admin->id;
        $data = Redis::get($key);

        if (! $data) {
            return $next($request);
        }

        $override = json_decode($data, true);

        // STEP 3 — Auto expiry
        if (
            empty($override['expires_at']) ||
            Carbon::now()->greaterThan(Carbon::parse($override['expires_at']))
        ) {
            Redis::del($key);

            return $next($request);
        }

        // STEP 4 — Mark request
        $request->attributes->set('emergency_override', true);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiHealthMetrics
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $duration = (microtime(true) - $start) * 1000; // ms
        $endpoint = $request->path(); // e.g., "api/users"

        // Store durations in Redis list for this endpoint
        $key = "metrics:summary:$endpoint";
        Redis::rpush($key.':latencies', $duration);

        // Keep last 1000 requests only
        Redis::ltrim($key.':latencies', -1000, -1);

        // Increment total requests for RPS calculation
        $rpsKey = 'metrics:rps:'.now()->format('YmdHi'); // YYYYMMDDHHMM
        Redis::incr($rpsKey);
        Redis::expire($rpsKey, 120); // auto-expire after 2 mins

        // Increment errors if response status >= 400
        if ($response->getStatusCode() >= 400) {
            $errorKey = "metrics:errors:$endpoint";
            Redis::incr($errorKey);
        }

        return $response;
    }
}

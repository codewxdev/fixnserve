<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function index()
    {
        $keys = Redis::keys('metrics:summary:*'); // All endpoint metrics
        $result = [];

        foreach ($keys as $key) {
            $endpoint = str_replace('metrics:summary:', '', $key);
            $metrics = Redis::hgetall($key);

            // Total requests for error rate calculation
            $totalRequests = Redis::get("metrics:total_requests:$endpoint") ?? 1;

            // Example dependency failures (DB, Redis, external API)
            $dependencies = [
                'db' => Redis::get("metrics:deps:$endpoint:db") ?? 0,
                'redis' => Redis::get("metrics:deps:$endpoint:redis") ?? 0,
                'external_api' => Redis::get("metrics:deps:$endpoint:external_api") ?? 0,
            ];

            $result[$endpoint] = [
                'p95' => $metrics['p95'] ?? 0,
                'p99' => $metrics['p99'] ?? 0,
                'avg' => $metrics['avg'] ?? 0,
                'rps' => Redis::get('metrics:rps:'.now()->format('YmdHi')) ?? 0,
                'errors' => $metrics['errors'] ?? 0,
                'error_rate' => round(($metrics['errors'] ?? 0) / $totalRequests * 100, 2),
                'dependency_failures' => $dependencies,
            ];
        }

        return response()->json($result);
    }
}

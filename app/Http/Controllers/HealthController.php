<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function index()
    {
        $endpoints = Redis::keys('metrics:summary:*');
        $result = [];

        foreach ($endpoints as $key) {
            $endpoint = str_replace('metrics:summary:', '', $key);
            $metrics = Redis::hgetall($key);
            $result[$endpoint] = [
                'p95' => $metrics['p95'] ?? 0,
                'p99' => $metrics['p99'] ?? 0,
                'avg' => $metrics['avg'] ?? 0,
                'rps' => Redis::get('metrics:rps:'.now()->format('YmdHi')) ?? 0,
                'errors' => Redis::get("metrics:errors:$endpoint") ?? 0,
            ];
        }

        return response()->json($result);
    }
}

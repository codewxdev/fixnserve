<?php

namespace App\Domains\Command\Controllers\Cp\V1;

use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class MetricsController extends BaseApiController
{
    /**
     * 🔹 TOP SUMMARY CARDS
     */
    public function summary()
    {
        $data = [
            'p95_latency_ms' => Redis::get('metrics:global:p95') ?? 0,
            'error_rate' => Redis::get('metrics:global:error_rate') ?? 0,
            'throughput_rps' => Redis::get('metrics:global:rps') ?? 0,
            'dependency_failures' => Redis::get('metrics:global:dependency_failures') ?? 0,
        ];

        return $this->success($data, 'metrics_summary_fetched');
    }

    /**
     * 🔹 P95 LATENCY GRAPH (TIME SERIES)
     */
    public function latencyTimeSeries(Request $request)
    {
        $minutes = $request->get('minutes', 60);
        $data = [];

        for ($i = $minutes; $i >= 0; $i--) {
            $timeKey = now()->subMinutes($i)->format('YmdHi');

            $data[] = [
                'time' => now()->subMinutes($i)->format('H:i'),
                'value' => Redis::get("metrics:latency:p95:$timeKey") ?? 0,
            ];
        }

        return $this->success([
            'interval' => '1m',
            'metric' => 'p95',
            'data' => $data,
        ], 'latency_timeseries_fetched');
    }

    /**
     * 🔹 PER ENDPOINT METRICS
     */
    public function endpoints()
    {
        $keys = Redis::keys('metrics:endpoint:*');
        $result = [];

        foreach ($keys as $key) {

            $endpoint = str_replace('metrics:endpoint:', '', $key);
            $metrics = Redis::hgetall($key);

            $result[$endpoint] = [
                'p95' => (float) ($metrics['p95'] ?? 0),
                'p99' => (float) ($metrics['p99'] ?? 0),
                'avg' => (float) ($metrics['avg'] ?? 0),
                'rps' => (int) ($metrics['rps'] ?? 0),
                'errors' => (int) ($metrics['errors'] ?? 0),
                'error_rate' => (float) ($metrics['error_rate'] ?? 0),
                'dependency_failures' => [
                    'db' => (int) ($metrics['db_failures'] ?? 0),
                    'redis' => (int) ($metrics['redis_failures'] ?? 0),
                    'external_api' => (int) ($metrics['external_failures'] ?? 0),
                ],
            ];
        }

        return $this->success(
            $result,
            'endpoint_metrics_fetched'
        );
    }

    /**
     * 🔹 SERVICE DEPENDENCIES
     */
    public function dependencies()
    {
        $data = [
            'mysql' => [
                'status' => DB::connection()->getPdo() ? 'healthy' : 'down',
                'latency_ms' => Redis::get('dependency:mysql:latency') ?? 0,
                'error_rate' => Redis::get('dependency:mysql:error_rate') ?? 0,
            ],
            'redis' => [
                'status' => Redis::ping() ? 'healthy' : 'down',
                'latency_ms' => Redis::get('dependency:redis:latency') ?? 0,
                'error_rate' => Redis::get('dependency:redis:error_rate') ?? 0,
            ],
            'search' => [
                'status' => Redis::get('dependency:search:status') ?? 'healthy',
                'latency_ms' => Redis::get('dependency:search:latency') ?? 0,
                'error_rate' => Redis::get('dependency:search:error_rate') ?? 0,
            ],
            'storage' => [
                'status' => Redis::get('dependency:s3:status') ?? 'healthy',
                'latency_ms' => Redis::get('dependency:s3:latency') ?? 0,
                'error_rate' => Redis::get('dependency:s3:error_rate') ?? 0,
            ],
        ];

        return $this->success(
            $data,
            'service_dependencies_fetched'
        );
    }
}

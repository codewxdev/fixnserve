<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class CalculateApiMetrics implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $keys = Redis::keys('metrics:summary:*:latencies');

        foreach ($keys as $key) {
            $latencies = Redis::lrange($key, 0, -1);
            $latencies = array_map('floatval', $latencies);
            if (empty($latencies)) {
                continue;
            }

            sort($latencies);

            $count = count($latencies);
            $p95 = $latencies[(int) floor($count * 0.95) - 1] ?? 0;
            $p99 = $latencies[(int) floor($count * 0.99) - 1] ?? 0;
            $avg = array_sum($latencies) / $count;

            // Save summary hash
            $endpoint = str_replace(':latencies', '', str_replace('metrics:summary:', '', $key));
            $summaryKey = "metrics:summary:$endpoint";

            Redis::hmset($summaryKey, [
                'p95' => $p95,
                'p99' => $p99,
                'avg' => $avg,
            ]);
        }
    }
}

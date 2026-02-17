<?php

namespace App\Domains\Command\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class CalculateApiMetrics implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $cursor = null;

        $globalLatencies = [];
        $globalRequests = 0;
        $globalErrors = 0;

        do {
            [$cursor, $keys] = Redis::scan($cursor, [
                'MATCH' => 'metrics:raw:*:latencies',
                'COUNT' => 100,
            ]);

            foreach ($keys as $latKey) {

                $endpoint = str_replace(
                    ['metrics:raw:', ':latencies'],
                    '',
                    $latKey
                );

                $latencies = array_map('floatval', Redis::lrange($latKey, 0, -1));

                if (empty($latencies)) {
                    continue;
                }

                sort($latencies);

                $count = count($latencies);

                $p95 = $latencies[max(0, (int) ceil($count * 0.95) - 1)];
                $p99 = $latencies[max(0, (int) ceil($count * 0.99) - 1)];
                $avg = array_sum($latencies) / $count;

                $requests = $this->sumMinuteKeys("metrics:raw:$endpoint:requests:*");
                $errors = $this->sumMinuteKeys("metrics:raw:$endpoint:errors:*");

                $errorRate = $requests > 0 ? round(($errors / $requests) * 100, 3) : 0;

                // store endpoint summary
                Redis::hmset("metrics:endpoint:$endpoint", [
                    'p95' => $p95,
                    'p99' => $p99,
                    'avg' => round($avg, 2),
                    'rps' => $requests,
                    'errors' => $errors,
                    'error_rate' => $errorRate,
                ]);

                // accumulate global
                $globalLatencies = array_merge($globalLatencies, $latencies);
                $globalRequests += $requests;
                $globalErrors += $errors;
            }

        } while ($cursor != 0);

        $this->storeGlobal($globalLatencies, $globalRequests, $globalErrors);
    }

    private function sumMinuteKeys(string $pattern): int
    {
        $cursor = null;
        $sum = 0;

        do {
            [$cursor, $keys] = Redis::scan($cursor, ['MATCH' => $pattern, 'COUNT' => 50]);

            foreach ($keys as $key) {
                $sum += (int) Redis::get($key);
            }

        } while ($cursor != 0);

        return $sum;
    }

    private function storeGlobal(array $latencies, int $requests, int $errors): void
    {
        if (empty($latencies)) {
            return;
        }

        sort($latencies);

        $count = count($latencies);

        $p95 = $latencies[max(0, (int) ceil($count * 0.95) - 1)];
        $errorRate = $requests > 0 ? round(($errors / $requests) * 100, 3) : 0;

        Redis::hmset('metrics:global', [
            'p95' => $p95,
            'rps' => $requests,
            'error_rate' => $errorRate,
        ]);
    }
}

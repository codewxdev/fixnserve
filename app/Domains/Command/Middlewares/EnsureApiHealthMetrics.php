<?php

namespace App\Domains\Command\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class EnsureApiHealthMetrics
{
    private const SAMPLE_LIMIT = 400;   // sliding window samples

    private const RAW_TTL = 120;        // 2 min only

    public function handle(Request $request, Closure $next)
    {
        $start = microtime(true);

        $response = $next($request);

        $latency = round((microtime(true) - $start) * 1000, 2);

        $endpoint = $this->normalizeEndpoint($request);
        $minute = now()->format('YmdHi');

        $latKey = "metrics:raw:$endpoint:latencies";
        $reqKey = "metrics:raw:$endpoint:requests:$minute";
        $errKey = "metrics:raw:$endpoint:errors:$minute";
        $rpsKey = "metrics:raw:global:rps:$minute";

        Redis::pipeline(function ($pipe) use ($latKey, $reqKey, $errKey, $rpsKey, $latency, $response) {

            // latency samples
            $pipe->rpush($latKey, $latency);
            $pipe->ltrim($latKey, -self::SAMPLE_LIMIT, -1);
            $pipe->expire($latKey, self::RAW_TTL);

            // request count
            $pipe->incr($reqKey);
            $pipe->expire($reqKey, self::RAW_TTL);

            // errors
            if ($response->getStatusCode() >= 500) {
                $pipe->incr($errKey);
                $pipe->expire($errKey, self::RAW_TTL);
            }

            // global rps
            $pipe->incr($rpsKey);
            $pipe->expire($rpsKey, self::RAW_TTL);
        });

        return $response;
    }

    private function normalizeEndpoint(Request $request): string
    {
        return str_replace('/', ':', trim($request->route()?->uri() ?? $request->path(), '/'));
    }
}

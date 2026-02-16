<?php

namespace App\Domains\Command\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class QueueController
{
    public function health(): JsonResponse
    {
        return response()->json([
            [
                'queue' => 'payment_processing',
                'pending' => Redis::llen('queues:payment_processing') ?? 0,
                'wait_time' => '2s',
                'failure_rate' => 0.01,
                'status' => 'active',
            ],
            [
                'queue' => 'notification_dispatch',
                'pending' => Redis::llen('queues:notification_dispatch') ?? 0,
                'wait_time' => '45s',
                'failure_rate' => 1.2,
                'status' => 'paused',
            ],
        ]);
    }
}

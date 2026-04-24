<?php

namespace App\Domains\Command\Controllers\Cp\V1;

use App\Http\Controllers\BaseApiController;
use Illuminate\Support\Facades\Redis;

class QueueController extends BaseApiController
{
    public function health()
    {
        $data = [
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
        ];

        return $this->success(
            $data,
            'queue_health_fetched'
        );
    }
}

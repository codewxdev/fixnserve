<?php

namespace App\Domains\Command\Controllers\Api;

use App\Http\Controllers\BaseApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class IncidentController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $incidents = Redis::lrange('incidents:timeline', 0, 10);
        // dd($incidents);

        return $this->success(
            collect($incidents)->map(fn ($i) => json_decode($i, true))
        );
    }
}

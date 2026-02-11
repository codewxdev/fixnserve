<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redis;

class IncidentController extends Controller
{
    public function index(): JsonResponse
    {
        $incidents = Redis::lrange('incidents:timeline', 0, 10);
        dd($incidents);

        return response()->json(
            collect($incidents)->map(fn ($i) => json_decode($i, true))
        );
    }
}

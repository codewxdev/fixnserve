<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        app(SubscriptionService::class)
            ->subscribe(auth()->user(), $plan);

        return response()->json(['status' => 'subscribed']);
    }
}

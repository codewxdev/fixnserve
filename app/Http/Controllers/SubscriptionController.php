<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService)
    {
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Subscribe / Upgrade / Downgrade
     */
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($data['subscription_plan_id']);

        $subscription = $this->subscriptionService
            ->subscribe(auth()->id(), $plan);

        return response()->json([
            'message' => 'Subscription activated successfully',
            'subscription' => $subscription,
        ]);
    }
}

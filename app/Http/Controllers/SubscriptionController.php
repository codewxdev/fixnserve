<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
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
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($data['plan_id']);

        // Authorization check (example)
        if (! auth()->user()->canSubscribeTo($plan->app_id)) {
            return response()->json([
                'message' => 'You are not allowed to subscribe to this app',
            ], 403);
        }

        $subscription = $this->subscriptionService
            ->subscribe(auth()->id(), $plan);

        return response()->json([
            'message' => 'Subscription activated successfully',
            'subscription' => $subscription,
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel()
    {
        $subscription = Subscription::where('user_id', auth()->id())
            ->whereIn('status', ['active', 'grace'])
            ->firstOrFail();

        $this->subscriptionService->cancel($subscription);

        return response()->json([
            'message' => 'Subscription cancelled successfully',
        ]);
    }

    /**
     * Check subscription status
     */
    public function status(Request $request)
    {
        $data = $request->validate([
            'app_id' => 'required|exists:apps,id',
        ]);

        return response()->json([
            'active' => $this->subscriptionService
                ->isActive(auth()->id(), $data['app_id']),
        ]);
    }

    /**
     * Get subscription entitlements
     */
    public function entitlements(Request $request)
    {
        $data = $request->validate([
            'app_id' => 'required|exists:apps,id',
        ]);

        return response()->json([
            'entitlements' => $this->subscriptionService
                ->getEntitlements(auth()->id(), $data['app_id']),
        ]);
    }
}

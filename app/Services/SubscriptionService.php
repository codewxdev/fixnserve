<?php

// app/Services/SubscriptionService.php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    public function subscribe($user, $plan)
    {
        DB::transaction(function () use ($user, $plan) {

            Subscription::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'app_id' => $plan->app_id,
                ],
                [
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'started_at' => now(),
                    'expires_at' => now()->addMonth(),
                ]
            );
        });
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'cancelled',
        ]);
    }

    public function isActive($user, $appId): bool
    {
        return Subscription::where('user_id', $user->id)
            ->where('app_id', $appId)
            ->whereIn('status', ['active', 'grace'])
            ->where('expires_at', '>', now())
            ->exists();
    }

    public function getEntitlements($user, $appId)
    {
        return Subscription::with('plan.entitlements')
            ->where('user_id', $user->id)
            ->where('app_id', $appId)
            ->first()
            ?->plan
            ?->entitlements
            ->pluck('value', 'feature_key');
    }
}

<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    /**
     * Create / Upgrade / Downgrade subscription
     */
    public function subscribe(int $userId, SubscriptionPlan $plan): Subscription
    {
        return DB::transaction(function () use ($userId, $plan) {

            $now = Carbon::now();

            return Subscription::updateOrCreate(
                [
                    'user_id' => $userId,
                    'app_id' => $plan->app_id,
                ],
                [
                    'subscription_plan_id' => $plan->id,
                    'subscription_status' => 'active',
                    'starts_at' => $now,
                    'ends_at' => $this->calculateExpiry($plan, $now),
                    'grace_ends_at' => null,
                ]
            );
        });
    }

    private function calculateExpiry(
        SubscriptionPlan $plan,
        Carbon $start
    ): Carbon {
        return match ($plan->billing_cycle) {
            'monthly' => $start->copy()->addMonth(),
            'yearly' => $start->copy()->addYear(),
        };
    }
}

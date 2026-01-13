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
                    'status' => 'active',
                    'started_at' => $now,
                    'expires_at' => $this->calculateExpiry($plan, $now),
                    'grace_ends_at' => null,
                ]
            );
        });
    }

    /**
     * Cancel subscription (manual or admin)
     */
    public function cancel(Subscription $subscription): void
    {
        $subscription->update([
            'status' => 'cancelled',
        ]);
    }

    /**
     * Check if subscription is valid for access
     */
    public function isActive(int $userId, int $appId): bool
    {
        return Subscription::where('user_id', $userId)
            ->where('app_id', $appId)
            ->whereIn('status', ['active', 'grace'])
            ->where('expires_at', '>', now())
            ->exists();
    }

    /**
     * Mark subscription as past due and start grace period
     */
    public function markPastDue(Subscription $subscription, int $graceDays = 7): void
    {
        $subscription->update([
            'status' => 'grace',
            'grace_ends_at' => now()->addDays($graceDays),
        ]);
    }

    /**
     * Expire subscription completely
     */
    public function expire(Subscription $subscription): void
    {
        $subscription->update([
            'status' => 'expired',
        ]);
    }

    /**
     * Auto-renew subscription
     */
    public function renew(Subscription $subscription): void
    {
        $now = now();

        $subscription->update([
            'status' => 'active',
            'started_at' => $now,
            'expires_at' => $this->calculateExpiry($subscription->plan, $now),
            'grace_ends_at' => null,
        ]);
    }

    /**
     * Resolve entitlements for current subscription
     */
    public function getEntitlements(int $userId, int $appId): array
    {
        $subscription = Subscription::with('plan.entitlements')
            ->where('user_id', $userId)
            ->where('app_id', $appId)
            ->first();

        if (! $subscription) {
            return [];
        }

        return $subscription->plan
            ->entitlements
            ->pluck('value', 'feature_key')
            ->toArray();
    }

    /**
     * Calculate expiry date based on billing cycle
     */
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

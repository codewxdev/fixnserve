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

    public function createPlan(array $data)
    {

        return DB::transaction(function () use ($data) {
            // 1. Create the Plan record
            $plan = SubscriptionPlan::create([
                'app_id'        => $data['app_id'],
                'name'          => $data['name'],
                'tier'          => $data['tier'],
                'price'         => $data['price'],
                'billing_cycle' => $data['billing_cycle'],
            ]);

            // 2. Check if features (entitlements) are provided
            if (!empty($data['features'])) {
                foreach ($data['features'] as $feature) {
                    $plan->entitlements()->create([
                        'feature_key'   => $feature['key'],
                        'feature_value' => $feature['value'],
                    ]);
                }
            }

            return $plan;
        });
    }


    // ... (previous code)

    public function updatePlan(SubscriptionPlan $plan, array $data)
    {
        return DB::transaction(function () use ($plan, $data) {
            // 1. Update Basic Info
            $plan->update([
                'name'          => $data['name'],
                'tier'          => $data['tier'],
                'price'         => $data['price'],
                'billing_cycle' => $data['billing_cycle'],
            ]);

            // 2. Update Features (Sabse asaan: Purane delete karo, naye daalo)
            $plan->entitlements()->delete();

            if (!empty($data['features'])) {
                foreach ($data['features'] as $feature) {
                    if (empty($feature['key'])) continue;

                    $plan->entitlements()->create([
                        'feature_key'   => $feature['key'],
                        'feature_value' => $feature['value'],
                    ]);
                }
            }

            return $plan;
        });
    }

    public function deletePlan(SubscriptionPlan $plan)
    {
        return DB::transaction(function () use ($plan) {
            // Entitlements cascade delete honi chahiye agar DB mein set hai,
            // warna manually delete karein:
            $plan->entitlements()->delete();
            $plan->delete();
            return true;
        });
    }
}

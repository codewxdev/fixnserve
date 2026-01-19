<?php

namespace App\Services;

use App\Models\App;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Exception;
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
        // DB Transaction shuru karte hain taaky data consistent rahe
        return DB::transaction(function () use ($data) {
            
            // 1. Plan Create karein
            $plan = SubscriptionPlan::create([
                'app_id'            => $data['app_id'],
                'name'              => $data['name'],
                'tier'              => $data['tier'], // e.g., Gold, Premium
                'price'             => $data['price'],
                'billing_cycle'     => $data['billing_cycle'],
                'visibility_weight' => $data['visibility_weight'] ?? 0,
            ]);

            // 2. Entitlements (Features) add karein
            // Hum form se features array lenge jisme key aur value hogi
            if (!empty($data['features'])) {
                foreach ($data['features'] as $feature) {
                    if(!empty($feature['key']) && !empty($feature['value'])) {
                        $plan->entitlements()->create([
                            'feature_key'   => $feature['key'],
                            'feature_value' => $feature['value'],
                        ]);
                    }
                }
            }

            return $plan;
        });
    }

    
   
}

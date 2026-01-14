<?php

namespace App\Services;

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


    // Sare plans fetch karo app relation ke sath
    public function getAllPlans()
    {
        return SubscriptionPlan::with(['app', 'entitlements'])->latest()->get();
    }


    private function getColorByTier($tier)
    {
        return match (strtolower($tier)) {
            'gold', 'premium' => 'yellow',
            'platinum' => 'indigo',
            'free', 'basic' => 'gray',
            default => 'blue',
        };
    }


   public function createPlan(array $data)
    {
        DB::beginTransaction();

        try {
            // 1. App ID nikalo 'vendor' ya 'rider' string se
            $app = App::where('app_key', $data['module_type'])->firstOrFail();

            // 2. Plan Save karo
            $plan = SubscriptionPlan::create([
                'app_id'        => $app->id,
                'name'          => $data['name'],
                'tagline'       => $data['tagline'] ?? null,
                'tier'          => 'standard', // Default tier, logic badha sakty ho
                'price'         => $data['price'],
                'billing_cycle' => $data['interval'], // Form 'interval' bhej rha hai, DB 'billing_cycle' hai
                'trial_days'    => $data['trial_days'] ?? 0,
            ]);

            // 3. Specific Features Save karo (Limits & Commission)
            $entitlements = [];

            if (isset($data['limit_items'])) {
                $plan->entitlements()->create([
                    'feature_key' => 'max_items',
                    'feature_value' => $data['limit_items']
                ]);
            }

            if (isset($data['commission_fee'])) {
                $plan->entitlements()->create([
                    'feature_key' => 'commission_percent',
                    'feature_value' => $data['commission_fee']
                ]);
            }

            // 4. Generic Display Features (Jo add more button se aaty hien)
            if (!empty($data['features'])) {
                foreach ($data['features'] as $featureText) {
                    if($featureText) {
                        $plan->entitlements()->create([
                            'feature_key' => 'display_feature', // Display purpose key
                            'feature_value' => $featureText
                        ]);
                    }
                }
            }

            DB::commit();
            return $plan;

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}

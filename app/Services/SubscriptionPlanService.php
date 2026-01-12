<?php

// app/Services/SubscriptionService.php

namespace App\Services;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanService
{
    public function create(array $data): SubscriptionPlan
    {
        return DB::transaction(function () use ($data) {
            return SubscriptionPlan::create($data);
        });
    }

    public function update(SubscriptionPlan $plan, array $data): SubscriptionPlan
    {
        return DB::transaction(function () use ($plan, $data) {
            $plan->update($data);

            return $plan;
        });
    }

    public function delete(SubscriptionPlan $plan): void
    {
        // Optional: prevent delete if active subscriptions exist
        if ($plan->subscriptions()->exists()) {
            throw new \Exception('Plan has active subscriptions');
        }

        $plan->delete();
    }

    public function toggleStatus(SubscriptionPlan $plan): SubscriptionPlan
    {
        $plan->update(['is_active' => ! $plan->is_active]);

        return $plan;
    }
}

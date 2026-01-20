<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanService
{
    /**
     * Create subscription plan (ADMIN)
     */
    public function create(array $data): SubscriptionPlan
    {
        return DB::transaction(function () use ($data) {

            $plan = SubscriptionPlan::create($data);

            // ✅ Audit log
            AuditLogService::log(
                auth()->id(),
                'create_subscription_plan',
                'subscription_plan',
                $plan->id,
                [],
                $plan->toArray()
            );

            return $plan;
        });
    }

    /**
     * Update subscription plan (ADMIN)
     */
    public function update(SubscriptionPlan $plan, array $data): SubscriptionPlan
    {
        return DB::transaction(function () use ($plan, $data) {

            $oldValues = $plan->toArray();

            $plan->update($data);

            // ✅ Audit log
            AuditLogService::log(
                auth()->id(),
                'update_subscription_plan',
                'subscription_plan',
                $plan->id,
                $oldValues,
                $plan->toArray()
            );

            return $plan;
        });
    }

    /**
     * Delete subscription plan (ADMIN)
     */
    public function delete(SubscriptionPlan $plan): void
    {
        if ($plan->subscriptions()->exists()) {
            throw new \Exception('Plan has active subscriptions');
        }

        $oldValues = $plan->toArray();

        $plan->delete();

        // ✅ Audit log
        AuditLogService::log(
            auth()->id(),
            'delete_subscription_plan',
            'subscription_plan',
            $plan->id,
            $oldValues,
            []
        );
    }

    /**
     * Enable / Disable plan (ADMIN)
     */
    public function toggleStatus(SubscriptionPlan $plan): SubscriptionPlan
    {
        $oldValues = $plan->toArray();

        $plan->update([
            'is_active' => ! $plan->is_active,
        ]);

        // ✅ Audit log
        AuditLogService::log(
            auth()->id(),
            'toggle_subscription_plan_status',
            'subscription_plan',
            $plan->id,
            $oldValues,
            $plan->toArray()
        );

        return $plan;
    }
}

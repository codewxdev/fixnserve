<?php

namespace App\Services;

use App\Models\SubscriptionEntitlement;
use Illuminate\Support\Facades\DB;

class SubscriptionEntitlementService
{
    /**
     * Create entitlement (ADMIN)
     */
    public function create(array $data): SubscriptionEntitlement
    {
        return DB::transaction(function () use ($data) {

            $entitlement = SubscriptionEntitlement::create($data);

            // ✅ Audit log
            AuditLogService::log(
                auth()->id(),
                'create_subscription_entitlement',
                'subscription_entitlement',
                $entitlement->id,
                [],
                $entitlement->toArray()
            );

            return $entitlement;
        });
    }

    /**
     * Update entitlement (ADMIN)
     */
    public function update(
        SubscriptionEntitlement $entitlement,
        array $data
    ): SubscriptionEntitlement {
        return DB::transaction(function () use ($entitlement, $data) {

            $oldValues = $entitlement->toArray();

            $entitlement->update($data);

            // ✅ Audit log
            AuditLogService::log(
                auth()->id(),
                'update_subscription_entitlement',
                'subscription_entitlement',
                $entitlement->id,
                $oldValues,
                $entitlement->toArray()
            );

            return $entitlement;
        });
    }
}

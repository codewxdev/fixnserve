<?php

// app/Services/SubscriptionService.php

namespace App\Services;

use App\Models\SubscriptionEntitlement;

class SubscriptionEntitlementService
{
    public function create(array $data): SubscriptionEntitlement
    {
        return SubscriptionEntitlement::create($data);
    }

    public function update(
        SubscriptionEntitlement $entitlement,
        array $data
    ): SubscriptionEntitlement {
        $entitlement->update($data);

        return $entitlement;
    }
}

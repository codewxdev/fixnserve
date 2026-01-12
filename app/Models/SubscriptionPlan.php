<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    protected $fillable = [
        'app_id', 'name', 'tier', 'billing_cycle',
        'price', 'visibility_weight',
    ];

    public function entitlements()
    {
        return $this->hasMany(SubscriptionEntitlement::class);
    }
}

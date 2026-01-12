<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionEntitlement extends Model
{
    protected $fillable = [
        'subscription_plan_id',
        'feature_key',
        'feature_value',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}

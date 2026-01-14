<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'app_id', 'user_id', 'subscription_plan_id',
        'subscription_status', 'starts_at', 'expires_at', 'ends_at', 'grace_ends_at', 'auto_renew',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'app_id', 'user_id', 'subscription_plan_id',
        'status', 'started_at', 'expires_at',
    ];

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}

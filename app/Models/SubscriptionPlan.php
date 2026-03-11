<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'tier',
    ];

    protected $fillable = [
        'app_id', 'name', 'tier', 'billing_cycle',
        'price', 'visibility_weight',
    ];

    public function app()
    {
        return $this->belongsTo(App::class);
    }

    public function entitlements()
    {
        return $this->hasMany(SubscriptionEntitlement::class, 'subscription_plan_id');
    }
}

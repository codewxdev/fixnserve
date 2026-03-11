<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SubscriptionEntitlement extends Model
{
    use HasTranslations;

    public array $translatable = ['feature_value',
    ];

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

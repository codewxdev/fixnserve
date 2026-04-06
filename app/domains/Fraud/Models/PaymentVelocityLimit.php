<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PaymentVelocityLimit extends Model
{
    use HasTranslations;

    protected $fillable = [
        'limit_key', 'label', 'max_count',
        'max_amount', 'window', 'is_active', 'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'translations' => 'array',
    ];
}

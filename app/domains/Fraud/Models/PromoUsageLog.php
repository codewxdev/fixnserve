<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PromoUsageLog extends Model
{
    use HasTranslations;

    protected $fillable = [
        'user_id', 'promo_code', 'device_hash',
        'ip_address', 'was_blocked', 'block_reason',
        'translations',
    ];

    protected $casts = [
        'was_blocked' => 'boolean',
        'translations' => 'array',
    ];
}

<?php

namespace App\Domains\System\Models;

use Illuminate\Database\Eloquent\Model;

class RateLimitConfiguration extends Model
{
    protected $fillable = [
        'api_rate_limit', 'burst_limit',
        'per_user_limit', 'per_ip_limit',
        'sms_limit', 'push_limit', 'email_limit',
        'emergency_throttling', 'translations',
    ];

    protected $casts = [
        'emergency_throttling' => 'boolean',
        'translations' => 'array',
    ];
}

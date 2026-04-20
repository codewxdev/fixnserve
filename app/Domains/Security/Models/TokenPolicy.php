<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class TokenPolicy extends Model
{
    protected $fillable = [

        'access_token_ttl_minutes',

        'refresh_token_ttl_days',

        'rotate_refresh_on_use',

        'grace_period_seconds',

        'updated_by',

    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [

        'rotate_refresh_on_use' => 'boolean',

    ];

    /**
     * Get current active policy
     */
    public static function current()
    {
        return self::first();
    }
}

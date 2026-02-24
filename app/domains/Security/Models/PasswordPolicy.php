<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordPolicy extends Model
{
    protected $fillable = [
        'min_length',
        'require_uppercase',
        'require_symbols',
        'prevent_reuse',
        'check_breached',
        'force_rotation_days',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public static function current()
    {
        return self::first() ?? self::create();
    }
}

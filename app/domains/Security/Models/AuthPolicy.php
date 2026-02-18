<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class AuthPolicy extends Model
{
    protected $fillable = [
        'login_email_password',
        'login_phone_otp',
        'login_oauth',
        'login_rules',
    ];

    protected $casts = [
        'login_rules' => 'array',
    ];

    public static function current()
    {
        return self::first() ?? self::create();
    }
}

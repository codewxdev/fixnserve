<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AuthPolicy extends Model
{
    use HasTranslations;

    public array $translatable = ['login_rules', 'login_email_password', 'login_phone_otp', 'login_oauth'];

    protected $fillable = [
        'login_email_password',
        'login_phone_otp',
        'login_oauth',
        'login_rules',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'login_rules' => 'array',
    ];

    public static function current()
    {
        return self::first() ?? self::create();
    }
}

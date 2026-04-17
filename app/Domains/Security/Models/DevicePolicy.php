<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class DevicePolicy extends Model
{
    use HasTranslations;

    public array $translatable = ['max_trusted_devices', 'trust_expiration_days', 'require_otp_new_device'];

    protected $fillable = [
        'max_trusted_devices',
        'trust_expiration_days',
        'require_otp_new_device',
        'block_rooted_devices',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}

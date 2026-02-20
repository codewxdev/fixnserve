<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class DevicePolicy extends Model
{
     protected $fillable = [
        'max_trusted_devices',
        'trust_expiration_days',
        'require_otp_new_device',
        'block_rooted_devices'
    ];
}

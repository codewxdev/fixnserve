<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyOverride extends Model
{
    protected $fillable = [
        'admin_id',
        'expires_at',
        'active',
        'reason',
        'mfa_verified_at',
    ];
}

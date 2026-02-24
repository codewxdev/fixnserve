<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class IpRule extends Model
{
    protected $fillable = [
        'cidr',
        'type',
        'applies_to',
        'comment',
        'expires_at',
        'is_active',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}

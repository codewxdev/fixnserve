<?php

namespace App\Domains\System\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformPreference extends Model
{
    protected $fillable = [
        'settings',
        'version',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];
}

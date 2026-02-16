<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyOverrideLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'override_id',
        'admin_id',
        'action',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}

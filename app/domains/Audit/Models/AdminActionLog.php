<?php

namespace App\Domains\Audit\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActionLog extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'before_state' => 'array',
        'after_state' => 'array',
        'performed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updating(fn () => false);
        static::deleting(fn () => false);
    }
}

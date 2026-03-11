<?php

namespace App\Domains\Audit\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SecurityAuditLog extends Model
{
    use HasTranslations;

    public array $translatable = ['event_type'];

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'event_data' => 'array',
        'occurred_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::updating(fn () => false);
        static::deleting(fn () => false);
    }

    public function user()
    {
        return $this->belongsTo(\App\Domains\Security\Models\User::class);
    }
}

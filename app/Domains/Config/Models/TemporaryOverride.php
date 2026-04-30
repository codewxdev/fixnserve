<?php

namespace App\Domains\Config\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryOverride extends Model
{
    protected $fillable = [
        'type', 'value', 'limit',
        'reason', 'expires_at', 'is_blocked',
        'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_blocked' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Check if override is still active
    public function isActive(): bool
    {
        return $this->expires_at->isFuture();
    }
}

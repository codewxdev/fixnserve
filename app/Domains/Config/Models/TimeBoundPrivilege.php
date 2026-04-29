<?php

namespace App\Domains\Config\Models;

use App\Domains\RBAC\Models\Role;
use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;

class TimeBoundPrivilege extends Model
{
    protected $fillable = [
        'target_admin_id',
        'granted_by_id',
        'role_id',
        'expires_at',
        'is_active',
        'revoked_at',
        'revoked_by_id',
        'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function targetAdmin()
    {
        return $this->belongsTo(User::class, 'target_admin_id');
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by_id');
    }

    public function revokedBy()
    {
        return $this->belongsTo(User::class, 'revoked_by_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ✅ Check if expired
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    // ✅ Remaining time in seconds
    public function remainingSeconds(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInSeconds($this->expires_at);
    }

    // ✅ Scope active only
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('expires_at', '>', now());
    }
}

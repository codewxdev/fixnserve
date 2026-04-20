<?php

namespace App\Domains\Fraud\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class IpBlock extends Model
{
    use HasTranslations;

    public array $translatable = ['reason', 'type'];

    protected $fillable = [
        'ip_address',
        'type',
        'reason',
        'block_count',
        'blocked_by',
        'is_active',
        'expires_at',
        'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function blockedBy()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    // ✅ Check if IP is blocked
    public static function isBlocked(string $ip): bool
    {
        return self::where('ip_address', $ip)
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }
}

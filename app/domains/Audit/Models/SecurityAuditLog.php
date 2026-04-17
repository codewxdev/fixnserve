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

    // ✅ Generate Log ID
    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('occurred_at', $year)->count() + 1;

        return 'SAL-'.$year.'-'.str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    // ✅ Scopes
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeAnomalies($query)
    {
        return $query->where('is_anomaly', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('success', false);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('occurred_at', today());
    }

    public function scopeByIp($query, string $ip)
    {
        return $query->where('ip_address', $ip);
    }
}

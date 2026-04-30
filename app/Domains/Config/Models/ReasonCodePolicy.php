<?php

namespace App\Domains\Config\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonCodePolicy extends Model
{
    protected $fillable = [
        'enforcement_level',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    // ✅ Check if reason required for this action
    public static function requiresReason(bool $isHighRisk = false): bool
    {
        $policy = self::first();
        if (! $policy) {
            return false;
        }

        return match ($policy->enforcement_level) {
            'strict' => true,              // Always required
            'moderate' => $isHighRisk,       // Only high risk
            'none' => false,             // Never required
            default => false,
        };
    }
}

<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RiskScore extends Model
{
    use HasTranslations;

    public array $translatable = ['reason_codes', 'signal_breakdown', 'tier', 'entity_type'];

    protected $fillable = [
        'entity_type', 'entity_id', 'score',
        'tier', 'reason_codes', 'signal_breakdown',
        'last_event_at', 'translations',
    ];

    protected $casts = [
        'reason_codes' => 'array',
        'signal_breakdown' => 'array',
        'last_event_at' => 'datetime',
        'translations' => 'array',
    ];

    // ✅ Get tier from score
    public static function getTier(int $score): string
    {
        return match (true) {
            $score <= 30 => 'low',
            $score <= 65 => 'medium',
            $score <= 89 => 'high',
            default => 'critical',
        };
    }

    // ✅ Scopes
    public function scopeByTier($query, string $tier)
    {
        return $query->where('tier', $tier);
    }

    public function scopeCritical($query)
    {
        return $query->where('tier', 'critical');
    }

    public function scopeByEntity($query, string $type, int $id)
    {
        return $query->where('entity_type', $type)
            ->where('entity_id', $id);
    }
}

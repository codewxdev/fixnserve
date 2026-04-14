<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PromoAbuseDetection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'entity_type', 'entity_id', 'entity_ref',
        'promo_code', 'promo_type', 'promo_amount',
        'abuse_pattern', 'pattern_detail', 'confidence_score',
        'system_action', 'status', 'clawback_amount',
        'meta', 'translations',
    ];

    protected $casts = [
        'meta' => 'array',
        'translations' => 'array',
    ];

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['detected', 'actioned']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}

<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CollusionRing extends Model
{
    use HasTranslations;

    protected $fillable = [
        'ring_id', 'ring_type', 'confidence_score',
        'actors_count', 'fraud_pattern_detail',
        'status', 'system_enforcement', 'is_active',
        'meta', 'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function actors()
    {
        return $this->hasMany(CollusionRingActor::class, 'ring_id');
    }

    public function investigation()
    {
        return $this->hasOne(CollusionInvestigation::class, 'ring_id');
    }

    // ✅ Generate Ring ID
    public static function generateRingId(): string
    {
        $last = self::orderBy('id', 'desc')->first();
        $next = $last ? (int) substr($last->ring_id, 5) + 1 : 2291;

        return 'RING-'.$next;
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDetected($query)
    {
        return $query->where('status', 'detected');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}

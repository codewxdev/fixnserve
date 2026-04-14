<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AbuseDetection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'entity_type', 'entity_id', 'entity_ref',
        'abuse_type', 'confidence_score', 'pattern_detail',
        'evidence', 'severity', 'enforcement_action',
        'status', 'synced_to_risk_module',
        'meta', 'translations',
    ];

    protected $casts = [
        'evidence' => 'array',
        'meta' => 'array',
        'synced_to_risk_module' => 'boolean',
        'translations' => 'array',
    ];

    public function enforcements()
    {
        return $this->hasMany(EnforcementAction::class, 'abuse_detection_id');
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['detected', 'enforced']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeByEntity($query, string $type, int $id)
    {
        return $query->where('entity_type', $type)
            ->where('entity_id', $id);
    }
}

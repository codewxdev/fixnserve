<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CollusionRingActor extends Model
{
    use HasTranslations;

    protected $fillable = [
        'ring_id', 'entity_type', 'entity_id',
        'entity_ref', 'role', 'evidence',
        'is_shadow_banned', 'ranking_suppressed',
        'translations',
    ];

    protected $casts = [
        'evidence' => 'array',
        'is_shadow_banned' => 'boolean',
        'ranking_suppressed' => 'boolean',
        'translations' => 'array',
    ];

    public function ring()
    {
        return $this->belongsTo(CollusionRing::class, 'ring_id');
    }
}

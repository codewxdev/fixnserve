<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RiskEvent extends Model
{
    use HasTranslations;

    public array $translatable = ['entity_type', 'event_type', 'event_data', 'score_delta'];

    protected $fillable = [
        'entity_type', 'entity_id', 'event_type',
        'event_data', 'score_before', 'score_after',
        'score_delta', 'translations',
    ];

    protected $casts = [
        'event_data' => 'array',
        'translations' => 'array',
    ];
}

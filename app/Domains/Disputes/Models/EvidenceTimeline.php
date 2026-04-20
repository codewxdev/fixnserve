<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EvidenceTimeline extends Model
{
    use HasTranslations;

    public array $translatable = ['event_description', 'actor_ref', 'case_ref', 'event_type', 'case_type'];

    protected $fillable = [
        'case_type', 'case_id', 'case_ref',
        'evidence_id', 'event_time', 'event_type',
        'event_description', 'actor_ref', 'translations',
    ];

    protected $casts = [
        'event_time' => 'datetime',
        'translations' => 'array',
    ];

    public function evidence()
    {
        return $this->belongsTo(CaseEvidence::class, 'evidence_id');
    }
}

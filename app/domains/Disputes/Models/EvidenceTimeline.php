<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EvidenceTimeline extends Model
{
    use HasTranslations;

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

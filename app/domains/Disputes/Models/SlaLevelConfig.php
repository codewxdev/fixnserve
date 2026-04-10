<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SlaLevelConfig extends Model
{
    use HasTranslations;

    protected $fillable = [
        'level', 'label',
        'first_response_hours',
        'resolution_hours',
        'approaching_alert_hours',
        'requires_supervisor',
        'requires_legal_review',
        'translations',
    ];

    protected $casts = [
        'requires_supervisor' => 'boolean',
        'requires_legal_review' => 'boolean',
        'translations' => 'array',
    ];

    public static function getForLevel(string $level): self
    {
        return self::where('level', $level)->firstOrFail();
    }
}

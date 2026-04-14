<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SlaConfig extends Model
{
    use HasTranslations;

    protected $fillable = [
        'severity', 'response_hours',
        'resolution_hours', 'auto_escalate',
        'escalate_after_hours', 'translations',
    ];

    protected $casts = [
        'auto_escalate' => 'boolean',
        'translations' => 'array',
    ];
}

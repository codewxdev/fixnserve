<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AppealPolicy extends Model
{
    use HasTranslations;

    protected $fillable = [
        'policy_key', 'max_appeals_per_user',
        'appeal_window_days', 'cooldown_hours',
        'review_sla_hours', 'require_new_evidence',
        'is_active', 'translations',
    ];

    protected $casts = [
        'require_new_evidence' => 'boolean',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public static function getActive(): self
    {
        return self::where('is_active', true)->firstOrFail();
    }
}

<?php

namespace App\Domains\Disputes\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ClassificationRule extends Model
{
    use HasTranslations;

    protected $fillable = [
        'rule_key', 'classification', 'keywords',
        'severity', 'sla_hours', 'priority',
        'is_active', 'translations',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->orderByDesc('priority');
    }
}

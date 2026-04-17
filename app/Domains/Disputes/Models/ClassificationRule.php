<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ClassificationRule extends Model
{
    use HasTranslations;

    public array $translatable = ['classification', 'keywords', 'rule_key'];

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

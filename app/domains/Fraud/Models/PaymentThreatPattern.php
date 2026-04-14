<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PaymentThreatPattern extends Model
{
    use HasTranslations;

    public array $translatable = ['name', 'description'];

    protected $fillable = [
        'pattern_key', 'name', 'description',
        'severity', 'auto_action', 'is_active',
        'detection_rules', 'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'detection_rules' => 'array',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

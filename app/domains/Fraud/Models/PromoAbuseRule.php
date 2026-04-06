<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class PromoAbuseRule extends Model
{
    use HasTranslations;

    protected $fillable = [
        'rule_key', 'label', 'action',
        'is_active', 'config', 'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class OverrideReasonCode extends Model
{
    use HasTranslations;

    public array $translatable = ['label', 'category'];

    protected $fillable = [
        'code',
        'label',
        'category',
        'requires_dual_approval',
        'is_active',
        'translations',
    ];

    protected $casts = [
        'requires_dual_approval' => 'boolean',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

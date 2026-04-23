<?php

namespace App\Domains\Fraud\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RiskSignalWeight extends Model
{
    use HasTranslations;

    public array $translatable = ['signal_label'];

    protected $fillable = [
        'signal_key', 'signal_label',
        'weight', 'impact', 'is_active', 'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'translations' => 'array',
    ];
}

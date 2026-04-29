<?php

namespace App\Domains\Config\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ReasonCode extends Model
{
    use HasTranslations;

    public array $translatable = ['label'];

    protected $fillable = [
        'code',
        'label',
        'is_active',
        'translations',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Check if reason code is valid
    public static function isValid(string $code): bool
    {
        return self::where('code', $code)
            ->where('is_active', true)
            ->exists();
    }
}

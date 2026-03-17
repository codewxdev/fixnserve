<?php

namespace App\Domains\System\Models;

use Illuminate\Database\Eloquent\Model;

class DualApprovalRule extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_label',
        'description',
        'requires_approval',
        'translations',
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Check if this setting needs approval
    public static function requiresApproval(string $settingKey): bool
    {
        return self::where('setting_key', $settingKey)
            ->where('requires_approval', true)
            ->exists();
    }
}

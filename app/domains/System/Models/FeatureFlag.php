<?php

namespace App\Domains\System\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureFlag extends Model
{
    protected $fillable = ['key', 'type', 'value'];

    protected $casts = [
        'value' => 'array', // JSON cast
    ];

    // Check if feature is enabled for a user
    public static function isEnabled(string $key, $user = null): bool
    {
        $flag = self::where('key', $key)->first();
        if (! $flag) {
            return false;
        }

        switch ($flag->type) {
            case 'boolean':
                return $flag->value['enabled'] ?? false;

            case 'percentage':
                $percentage = $flag->value['percentage'] ?? 0;
                if (! $user) {
                    return false;
                }

                return (crc32($user->id) % 100) < $percentage;

            case 'user_segment':
                $segments = $flag->value['segments'] ?? [];
                if (! $user) {
                    return false;
                }

                return in_array($user->segment ?? null, $segments);

            default:
                return false;
        }
    }
}

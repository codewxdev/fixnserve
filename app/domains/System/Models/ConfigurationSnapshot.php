<?php

namespace App\Domains\System\Models;

use App\Domains\Security\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ConfigurationSnapshot extends Model
{
    use HasTranslations;

    public array $translatable = ['change_summary'];

    protected $fillable = [
        'version_id',
        'module',
        'created_by',
        'snapshot',
        'changes',
        'change_summary',
        'status',
        'is_manual',
        'translations',
    ];

    protected $casts = [
        'snapshot' => 'array',
        'changes' => 'array',
        'is_manual' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Generate next version ID
    public static function generateVersionId(string $module): string
    {
        $latest = self::where('module', $module)
            ->orderBy('id', 'desc') // ✅ created_at ki bajaye id use karo
            ->first();

        if (! $latest) {
            return 'v1.0.0';
        }

        // ✅ Parse version
        preg_match('/v(\d+)\.(\d+)\.(\d+)/', $latest->version_id, $matches);

        if (empty($matches)) {
            return 'v1.0.0';
        }

        $major = (int) $matches[1];
        $minor = (int) $matches[2];
        $patch = (int) $matches[3] + 1;

        $newVersion = "v{$major}.{$minor}.{$patch}";

        // ✅ Double check - agar ye version exist karta hai increment karo
        while (self::where('module', $module)
            ->where('version_id', $newVersion)
            ->exists()) {
            $patch++;
            $newVersion = "v{$major}.{$minor}.{$patch}";
        }

        return $newVersion;
    }

    // ✅ Calculate diff
    public static function calculateDiff(array $old, array $new): array
    {
        $diff = [];

        foreach ($new as $key => $value) {
            if (! isset($old[$key])) {
                $diff[$key] = [
                    'type' => 'added',
                    'old' => null,
                    'new' => $value,
                ];
            } elseif ($old[$key] !== $value) {
                $diff[$key] = [
                    'type' => 'modified',
                    'old' => $old[$key],
                    'new' => $value,
                ];
            }
        }

        foreach ($old as $key => $value) {
            if (! isset($new[$key])) {
                $diff[$key] = [
                    'type' => 'removed',
                    'old' => $value,
                    'new' => null,
                ];
            }
        }

        return $diff;
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function scopeForModule($query, string $module)
    {
        return $query->where('module', $module);
    }
}

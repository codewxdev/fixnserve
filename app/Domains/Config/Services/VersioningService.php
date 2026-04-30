<?php

namespace App\Domains\Config\Services;

use App\Domains\Config\Models\ConfigurationSnapshot;
use App\Domains\Config\Models\GeoConfiguration;
use App\Domains\Config\Models\Geofence;
use App\Domains\Config\Models\RateLimitConfiguration;
use Illuminate\Support\Facades\Log;

class VersioningService
{
    // ✅ Create snapshot
    public function createSnapshot(
        string $module,
        array $newConfig,
        string $changeSummary = '',
        bool $isManual = false
    ): ?ConfigurationSnapshot {

        try {
            // Get previous active
            $previous = ConfigurationSnapshot::where('module', $module)
                ->where('status', 'active')
                ->first();

            // Calculate diff
            $changes = $previous
                ? ConfigurationSnapshot::calculateDiff(
                    $previous->snapshot,
                    $newConfig
                )
                : [];

            // Archive previous
            if ($previous) {
                $previous->update(['status' => 'archived']);
            }

            // ✅ Generate version with module
            $versionId = ConfigurationSnapshot::generateVersionId($module);

            Log::info("📸 Creating snapshot: {$versionId} for module: {$module}");

            return ConfigurationSnapshot::create([
                'version_id' => $versionId,
                'module' => $module,
                'created_by' => auth()->id() ?? 1,
                'snapshot' => $newConfig,
                'changes' => $changes,
                'change_summary' => $changeSummary ?: $this->generateSummary($changes),
                'status' => 'active',
                'is_manual' => $isManual,
            ]);

        } catch (\Exception $e) {
            Log::error('❌ Snapshot creation failed: '.$e->getMessage());

            return null; // ✅ App crash na ho
        }
    }

    // ✅ Get current config
    public function getCurrentConfig(string $module): array
    {
        return match ($module) {
            'geo' => GeoConfiguration::first()?->toArray() ?? [],
            'rate_limits' => RateLimitConfiguration::first()?->toArray() ?? [],
            'geofences' => Geofence::all()->toArray(),
            default => [],
        };
    }

    // ✅ Apply config back to DB (for rollback)
    public function applyConfig(string $module, array $config): void
    {
        match ($module) {
            'geo' => GeoConfiguration::updateOrCreate(
                ['id' => 1],
                collect($config)->except([
                    'id', 'created_at', 'updated_at', 'translations',
                ])->toArray()
            ),
            'rate_limits' => RateLimitConfiguration::updateOrCreate(
                ['id' => 1],
                collect($config)->except([
                    'id', 'created_at', 'updated_at', 'translations',
                ])->toArray()
            ),
            default => null,
        };
    }

    // ✅ Auto generate summary
    private function generateSummary(array $changes): string
    {
        if (empty($changes)) {
            return 'Configuration updated';
        }

        $parts = [];
        foreach ($changes as $key => $change) {
            $parts[] = match ($change['type']) {
                'added' => "Added {$key}",
                'modified' => "Updated {$key}",
                'removed' => "Removed {$key}",
                default => "Changed {$key}",
            };
        }

        return implode(', ', array_slice($parts, 0, 3));
    }
}

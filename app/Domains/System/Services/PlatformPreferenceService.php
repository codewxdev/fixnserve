<?php

namespace App\Domains\System\Services;

use App\Domains\Audit\Services\SecurityAuditService;
use App\Domains\System\Models\PlatformPreference;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PlatformPreferenceService
{
    public function update(array $settings, string $rolloutMode)
    {
        DB::beginTransaction();

        $current = PlatformPreference::where('is_active', true)->first();

        $validated = $this->validateImpact($settings);

        $new = PlatformPreference::create([
            'settings' => $validated,
            'version' => Str::uuid(),
            'is_active' => false,
        ]);

        if ($rolloutMode === 'immediate') {
            $this->publish($new);
        }

        $this->audit($current, $new);

        DB::commit();

        return $new;
    }

    private function validateImpact(array $settings)
    {
        if (isset($settings['currency']['decimal_places']) &&
            $settings['currency']['decimal_places'] > 4) {
            throw new Exception('Decimal places cannot exceed 4');
        }

        return $settings;
    }

    public function publish(PlatformPreference $config)
    {
        PlatformPreference::where('is_active', true)
            ->update(['is_active' => false]);

        $config->update([
            'is_active' => true,
            'published_at' => now(),
        ]);

        Cache::forever('platform_preferences', $config->settings);
    }

    private function audit($before, $after)
    {
        app(SecurityAuditService::class)->log(
            'platform_preferences_updated',
            ['version' => $after->version],
            auth()->user(),
            $before?->settings,
            $after->settings,
            'Global platform settings updated'
        );
    }
}

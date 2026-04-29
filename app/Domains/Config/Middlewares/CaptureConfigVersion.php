<?php

namespace App\Domains\Config\Middlewares;

use App\Domains\Config\Models\ConfigurationSnapshot;
use App\Domains\Config\Services\VersioningService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CaptureConfigVersion
{
    public function __construct(
        protected VersioningService $versioningService
    ) {}

    // ✅ Routes to version
    protected array $versionedRoutes = [
        'api/geo/config' => 'geo',
        'api/geo/geofences' => 'geofences',
        'api/geo/geofences/*' => 'geofences',
        'api/geo/emergency-lock' => 'geo',
        'api/rate-limits/save' => 'rate_limits',
        'api/rate-limits/emergency' => 'rate_limits',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // dd($request);
        Log::info('🔍 CaptureConfigVersion fired', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
        ]);

        // ✅ Only mutating methods
        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            Log::info('❌ Skipped - not a mutating method');

            return $next($request);
        }

        // ✅ Get module for this route
        $module = $this->getModule($request);
        Log::info('🔍 Module detected: '.($module ?? 'NULL'));

        if (! $module) {
            Log::info('❌ Skipped - no module matched');

            return $next($request);
        }

        // ✅ Capture OLD config before change
        $oldConfig = $this->versioningService->getCurrentConfig($module);
        Log::info('📸 OLD config captured', $oldConfig);

        // ✅ Proceed with request
        $response = $next($request);
        Log::info('✅ Response status: '.$response->getStatusCode());

        // ✅ Only snapshot on success
        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            Log::info('📸 NEW config captured');

            // ✅ Capture NEW config after change
            $newConfig = $this->versioningService->getCurrentConfig($module);

            // ✅ Only create if actually changed
            if ($oldConfig !== $newConfig) {
                $snapshot = $this->versioningService->createSnapshot(
                    module: $module,
                    newConfig: $newConfig,
                    changeSummary: $this->generateSummary($oldConfig, $newConfig),
                    isManual: false
                );
                Log::info('✅ Snapshot created: '.$snapshot->version_id);

            }
            Log::info('⚠️ Config NOT changed - skipping snapshot');

        }

        return $response;
    }

    // ✅ Match route to module
    private function getModule(Request $request): ?string
    {
        foreach ($this->versionedRoutes as $route => $module) {
            if ($request->is($route)) {
                return $module;
            }
        }

        return null;
    }

    // ✅ Generate summary from diff
    private function generateSummary(array $old, array $new): string
    {
        $diff = ConfigurationSnapshot::calculateDiff($old, $new);
        $parts = [];

        foreach ($diff as $key => $change) {
            // ✅ Fix: value array ho sakti hai - json mein convert karo
            $oldVal = is_array($change['old'])
                ? json_encode($change['old'])
                : $change['old'];

            $newVal = is_array($change['new'])
                ? json_encode($change['new'])
                : $change['new'];

            $parts[] = match ($change['type']) {
                'added' => "Added {$key}",
                'modified' => "Updated {$key}: {$oldVal} → {$newVal}",
                'removed' => "Removed {$key}",
                default => "Changed {$key}",
            };
        }

        return ! empty($parts)
            ? implode(', ', array_slice($parts, 0, 3))
            : 'Configuration updated';
    }
}

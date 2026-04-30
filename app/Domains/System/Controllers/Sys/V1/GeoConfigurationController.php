<?php

namespace App\Domains\System\Controllers\Sys\V1;

use App\Domains\System\Models\ConfigurationSnapshot;
use App\Domains\System\Models\GeoConfiguration;
use App\Domains\System\Models\RateLimitConfiguration;
use App\Domains\System\Services\GeoService;
use App\Domains\System\Services\RateLimitService;
use App\Domains\System\Services\VersioningService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class GeoConfigurationController extends BaseApiController
{
    protected GeoService $geoService;

    protected RateLimitService $rateLimitService;

    protected VersioningService $versioningService;

    public function __construct(
        GeoService $geoService,
        RateLimitService $rateLimitService,
        VersioningService $versioningService
    ) {
        $this->geoService = $geoService;
        $this->rateLimitService = $rateLimitService;
        $this->versioningService = $versioningService;
    }
    // ✅ CHECK if location is serviceable (Global Use)

    public function checkLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $result = $this->geoService->checkLocation($request->lat, $request->lng);

        return $this->success($result, 'location_checked');
    }

    // ✅ EMERGENCY GEO LOCK
    public function emergencyGeoLock(Request $request)
    {
        $config = GeoConfiguration::firstOrCreate(['id' => 1]);
        $config->update(['emergency_geo_lock' => ! $config->emergency_geo_lock]);

        // ✅ Broadcast emergency lock to all services
        $this->geoService->handleEmergencyLock($config->emergency_geo_lock);

        return $this->success(
            [
                'emergency_geo_lock' => $config->emergency_geo_lock,
                'message' => $config->emergency_geo_lock ? '🔒 Emergency Geo-Lock ACTIVATED' : '🔓 Emergency Geo-Lock DEACTIVATED',
            ],
            'emergency_geo_lock_toggled',
        );
    }

    // ✅ EMERGENCY throttling toggle
    public function emergencyThrottling()
    {
        $config = RateLimitConfiguration::firstOrCreate(['id' => 1]);
        $config->update(['emergency_throttling' => ! $config->emergency_throttling]);

        $this->rateLimitService->refreshConfig();

        return $this->success(
            [
                'emergency_throttling' => $config->emergency_throttling,
                'message' => $config->emergency_throttling ? '🚨 Emergency Throttling ENABLED' : '✅ Emergency Throttling DISABLED',
            ],
            'emergency_throttling_toggled',
        );
    }

    // ✅ POST create manual snapshot
    public function createManualSnapshot(Request $request)
    {
        $validated = $request->validate([
            'module' => 'required|in:geo,rate_limits,geofences',
            'change_summary' => 'nullable|string|max:500',
        ]);

        $currentConfig = $this->versioningService->getCurrentConfig($validated['module']);

        if (empty($currentConfig)) {
            return $this->error('no_config_found_for_module', 404);
        }

        $snapshot = $this->versioningService->createSnapshot(module: $validated['module'], newConfig: $currentConfig, changeSummary: $validated['change_summary'] ?? 'Manual snapshot', isManual: true);

        return $this->success($snapshot, 'manual_snapshot_created', 201);
    }

    // ✅ POST rollback
    public function rollback(Request $request, ConfigurationSnapshot $snapshot)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if ($snapshot->status === 'active') {
            return $this->error('cannot_rollback_to_active_version', 422);
        }

        // ✅ Apply old config to DB
        $this->versioningService->applyConfig($snapshot->module, $snapshot->snapshot);

        // ✅ Create rollback snapshot
        $rollbackSnapshot = $this->versioningService->createSnapshot(module: $snapshot->module, newConfig: $snapshot->snapshot, changeSummary: "Rollback to {$snapshot->version_id}: {$request->reason}", isManual: true);

        return $this->success(
            [
                'new_version' => $rollbackSnapshot,
                'rolled_back_to' => $snapshot->version_id,
                'message' => "✅ Rolled back to {$snapshot->version_id}",
            ],
            'rollback_successful',
        );
    }
}

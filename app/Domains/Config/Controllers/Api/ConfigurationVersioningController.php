<?php

namespace App\Domains\Config\Controllers\Api;

use App\Domains\Config\Models\ConfigurationSnapshot;
use App\Domains\Config\Services\VersioningService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class ConfigurationVersioningController extends BaseApiController
{
    public function __construct(
        protected VersioningService $versioningService
    ) {}

    // ✅ GET version history
    public function index(Request $request)
    {
        $request->validate([
            'module' => 'nullable|in:geo,rate_limits,geofences,all',
        ]);

        $query = ConfigurationSnapshot::with('author:id,name,email')
            ->latest();

        if ($request->module && $request->module !== 'all') {
            $query->where('module', $request->module);
        }

        $versions = $query->get()->map(function ($version) {
            return [
                'id' => $version->id,
                'version_id' => $version->version_id,
                'module' => $version->module,
                'author' => $version->author->name ?? 'System',
                'change_summary' => $version->change_summary,
                'changes_count' => count($version->changes ?? []),
                'status' => $version->status,
                'is_manual' => $version->is_manual,
                'created_at' => $version->created_at->format('M d, Y h:i A'),
            ];
        });

        return $this->success($versions, 'version_history_fetched');
    }

    // ✅ GET single version
    public function show(ConfigurationSnapshot $snapshot)
    {
        return $this->success(
            $snapshot->load('author:id,name,email'),
            'version_fetched'
        );
    }

    // ✅ POST create manual snapshot
    public function createManualSnapshot(Request $request)
    {
        $validated = $request->validate([
            'module' => 'required|in:geo,rate_limits,geofences',
            'change_summary' => 'nullable|string|max:500',
        ]);

        $currentConfig = $this->versioningService
            ->getCurrentConfig($validated['module']);

        if (empty($currentConfig)) {
            return $this->error('no_config_found_for_module', 404);
        }

        $snapshot = $this->versioningService->createSnapshot(
            module: $validated['module'],
            newConfig: $currentConfig,
            changeSummary: $validated['change_summary'] ?? 'Manual snapshot',
            isManual: true
        );

        return $this->success($snapshot, 'manual_snapshot_created', 201);
    }

    // ✅ GET compare two versions
    public function compare(Request $request)
    {
        $request->validate([
            'version_1' => 'required|exists:configuration_snapshots,id',
            'version_2' => 'required|exists:configuration_snapshots,id|different:version_1',
        ]);

        $version1 = ConfigurationSnapshot::with('author:id,name')
            ->findOrFail($request->version_1);

        $version2 = ConfigurationSnapshot::with('author:id,name')
            ->findOrFail($request->version_2);

        $diff = ConfigurationSnapshot::calculateDiff(
            $version1->snapshot,
            $version2->snapshot
        );

        return $this->success([
            'version_1' => [
                'id' => $version1->id,
                'version_id' => $version1->version_id,
                'author' => $version1->author->name ?? 'System',
                'created_at' => $version1->created_at->format('M d, Y h:i A'),
                'snapshot' => $version1->snapshot,
            ],
            'version_2' => [
                'id' => $version2->id,
                'version_id' => $version2->version_id,
                'author' => $version2->author->name ?? 'System',
                'created_at' => $version2->created_at->format('M d, Y h:i A'),
                'snapshot' => $version2->snapshot,
            ],
            'diff' => $diff,
            'total_changes' => count($diff),
            'added_count' => count(array_filter($diff, fn ($d) => $d['type'] === 'added')),
            'modified_count' => count(array_filter($diff, fn ($d) => $d['type'] === 'modified')),
            'removed_count' => count(array_filter($diff, fn ($d) => $d['type'] === 'removed')),
        ], 'versions_compared');
    }

    // ✅ GET preview rollback impact
    public function previewRollback(ConfigurationSnapshot $snapshot)
    {
        $current = ConfigurationSnapshot::where('module', $snapshot->module)
            ->where('status', 'active')
            ->first();

        if (! $current) {
            return $this->error('no_active_version_found', 404);
        }

        if (strtolower(trim($snapshot->status)) === 'active') {
            return $this->error('already_active_version', 422);
        }

        $impact = ConfigurationSnapshot::calculateDiff(
            $current->snapshot,
            $snapshot->snapshot
        );

        return $this->success([
            'current_version' => $current->version_id,
            'rollback_to' => $snapshot->version_id,
            'impact' => $impact,
            'total_changes' => count($impact),
            'warning' => count($impact) > 5
                ? '⚠️ High impact - many settings will change'
                : null,
        ], 'rollback_impact_previewed');
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
        $this->versioningService->applyConfig(
            $snapshot->module,
            $snapshot->snapshot
        );

        // ✅ Create rollback snapshot
        $rollbackSnapshot = $this->versioningService->createSnapshot(
            module: $snapshot->module,
            newConfig: $snapshot->snapshot,
            changeSummary: "Rollback to {$snapshot->version_id}: {$request->reason}",
            isManual: true
        );

        return $this->success([
            'new_version' => $rollbackSnapshot,
            'rolled_back_to' => $snapshot->version_id,
            'message' => "✅ Rolled back to {$snapshot->version_id}",
        ], 'rollback_successful');
    }
}

<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\AbuseDetection;
use App\Domains\Disputes\Models\AbusePolicy;
use App\Domains\Disputes\Models\EnforcementAction;
use App\Domains\Disputes\Services\AbuseEnforcementService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class AbuseEnforcementController extends BaseApiController
{
    public function __construct(
        protected AbuseEnforcementService $abuseService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->abuseService->getDashboardStats(),
            'abuse_dashboard_fetched'
        );
    }

    // ✅ 2. All Detections
    public function index(Request $request)
    {
        $detections = AbuseDetection::with('enforcements')
            ->when($request->abuse_type, fn ($q) => $q->where('abuse_type', $request->abuse_type))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->entity_type, fn ($q) => $q->where('entity_type', $request->entity_type))
            ->latest()
            ->paginate(20);

        return $this->success($detections, 'abuse_detections_fetched');
    }

    // ✅ 3. Single Detection
    public function show(AbuseDetection $detection)
    {
        return $this->success(
            $detection->load('enforcements.enforcedBy:id,name'),
            'abuse_detection_fetched'
        );
    }

    // ✅ 4. Manual Enforce
    public function manualEnforce(
        Request $request,
        AbuseDetection $detection
    ) {
        $request->validate([
            'enforcement_action' => 'required|in:warning,refund_limit,account_restriction,wallet_lock,risk_escalation,permanent_ban',
            'expires_at' => 'nullable|date|after:now',
            'reason' => 'required|string|max:500',
        ]);

        $detection->update([
            'enforcement_action' => $request->enforcement_action,
        ]);

        $this->abuseService->enforce($detection);

        return $this->success(
            $detection->fresh()->load('enforcements'),
            'enforcement_applied'
        );
    }

    // ✅ 5. Lift Restriction
    public function liftRestriction(
        Request $request,
        EnforcementAction $enforcement
    ) {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $enforcement->update(['is_active' => false]);

        // Clear cache
        Cache::forget("refund_limited:{$enforcement->entity_type}:{$enforcement->entity_id}");
        Cache::forget("account_restricted:{$enforcement->entity_type}:{$enforcement->entity_id}");

        return $this->success($enforcement, 'restriction_lifted');
    }

    // ✅ 6. Mark False Positive
    public function markFalsePositive(
        Request $request,
        AbuseDetection $detection
    ) {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $detection->update([
            'status' => 'false_positive',
            'meta' => array_merge($detection->meta ?? [], [
                'fp_reason' => $request->reason,
                'marked_by' => auth()->id(),
                'marked_at' => now()->toDateTimeString(),
            ]),
        ]);

        // Lift all active enforcements
        EnforcementAction::where('abuse_detection_id', $detection->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Clear restrictions
        Cache::forget("refund_limited:{$detection->entity_type}:{$detection->entity_id}");
        Cache::forget("account_restricted:{$detection->entity_type}:{$detection->entity_id}");

        return $this->success($detection, 'marked_false_positive');
    }

    // ✅ 7. Entity Abuse History
    public function entityHistory(
        string $entityType,
        int $entityId
    ) {
        $detections = AbuseDetection::byEntity($entityType, $entityId)
            ->with('enforcements')
            ->latest()
            ->get();

        $activeEnforcements = EnforcementAction::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->active()
            ->get();

        return $this->success([
            'entity_ref' => strtoupper(substr($entityType, 0, 1)).'-'.$entityId,
            'total_detections' => $detections->count(),
            'active_enforcements' => $activeEnforcements->count(),
            'detections' => $detections,
            'restrictions' => $activeEnforcements,
            'risk_module_synced' => $detections->where('synced_to_risk_module', true)->count(),
        ], 'entity_abuse_history_fetched');
    }

    // ✅ 8. Sync to Risk Module
    public function syncToRiskModule(AbuseDetection $detection)
    {
        if ($detection->synced_to_risk_module) {
            return $this->error('already_synced', 422);
        }

        app(AbuseEnforcementService::class)->syncToRiskModule($detection);

        return $this->success(
            $detection->fresh(),
            'synced_to_risk_module'
        );
    }

    // ✅ 9. Get Policy
    public function getPolicy()
    {
        $policy = AbusePolicy::getActive();

        return $this->success($policy, 'abuse_policy_fetched');
    }

    // ✅ 10. Update Policy
    public function updatePolicy(
        Request $request,
        AbusePolicy $policy
    ) {
        $data = $request->validate([
            'max_disputes_per_month' => 'sometimes|integer|min:1',
            'max_refunds_per_month' => 'sometimes|integer|min:1',
            'false_claim_threshold' => 'sometimes|integer|min:1',
            'refund_amount_threshold' => 'sometimes|numeric|min:0',
            'coordinated_complaint_threshold' => 'sometimes|integer|min:1',
            'auto_enforce' => 'sometimes|boolean',
        ]);

        $policy->update($data);

        return $this->success($policy, 'abuse_policy_updated');
    }

    // ✅ 11. Export
    public function export()
    {
        $detections = AbuseDetection::with('enforcements')->latest()->get();
        $filename = 'abuse_detections_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($detections) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Entity', 'Abuse Type', 'Confidence',
                'Severity', 'Action', 'Status',
                'Risk Synced', 'Date',
            ]);
            foreach ($detections as $d) {
                fputcsv($file, [
                    $d->entity_ref, $d->abuse_type,
                    $d->confidence_score.'%',
                    $d->severity, $d->enforcement_action,
                    $d->status,
                    $d->synced_to_risk_module ? 'Yes' : 'No',
                    $d->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

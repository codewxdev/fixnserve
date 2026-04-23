<?php

namespace App\Domains\Fraud\Controllers\Api;

use App\Domains\Fraud\Models\OverrideReasonCode;
use App\Domains\Fraud\Services\ManualOverrideService;
use App\Domains\Security\Models\ApprovalAuditLog;
use App\Domains\Security\Models\DualApproval;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ManualOverrideController extends BaseApiController
{
    public function __construct(
        protected ManualOverrideService $overrideService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        $metrics = $this->overrideService->getMetrics();

        $pendingDual = DualApproval::needsDualApproval()
            ->with('requestedBy:id,name')
            ->latest()
            ->get();

        return $this->success([
            'metrics' => $metrics,
            'pending_approvals' => $pendingDual,
        ], 'override_dashboard_fetched');
    }

    // ✅ 2. All Overrides
    public function index(Request $request)
    {
        $overrides = DualApproval::with([
            'requestedBy:id,name',
            'approverLevel1:id,name',
            'approverLevel2:id,name',
        ])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->action_type, fn ($q) => $q->where('action_type', $request->action_type))
            ->latest()
            ->paginate(20);

        return $this->success($overrides, 'overrides_fetched');
    }

    // ✅ 3. Pending Dual Approvals
    public function pendingDualApprovals()
    {
        $pending = DualApproval::needsDualApproval()
            ->with('requestedBy:id,name')
            ->latest()
            ->get();

        return $this->success($pending, 'pending_dual_approvals_fetched');
    }

    // ✅ 4. Single Detail
    public function show(DualApproval $override)
    {
        return $this->success(
            $override->load([
                'requestedBy:id,name',
                'approverLevel1:id,name',
                'approverLevel2:id,name',
                'auditLogs',
            ]),
            'override_detail_fetched'
        );
    }

    // ✅ 5. Initiate Override Request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'target_entity_id' => 'required|string',
            'entity_type' => 'required|in:customer,rider,vendor,provider,consultant',
            'entity_db_id' => 'nullable|integer',
            'action_type' => 'required|in:wallet_unfreeze,wallet_freeze,account_unfreeze,account_suspend,suspension_rollback,risk_score_override,force_allow,force_block,enforcement_rollback,refund,kill_switch',
            'reason_code' => 'required|exists:override_reason_codes,code',
            'justification' => 'required|string|min:20|max:1000',
            'time_limit' => 'required|in:permanent,1_hour,6_hours,24_hours,7_days,30_days',
        ]);

        $override = $this->overrideService->createOverride($validated, $request);

        return $this->success(
            $override->load('requestedBy:id,name'),
            'override_request_created',
            201
        );
    }

    // ✅ 6. Approve Level 1
    public function approveLevel1(Request $request, DualApproval $override)
    {
        if ($override->status !== 'pending') {
            return $this->error('invalid_override_status', 422);
        }

        try {
            $result = $this->overrideService->approveLevel1($override, $request);

            return $this->success($result, 'level_1_approved');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    // ✅ 7. Approve Level 2
    public function approveLevel2(Request $request, DualApproval $override)
    {
        if ($override->status !== 'approved_level_1') {
            return $this->error('level_1_approval_required_first', 422);
        }

        try {
            $result = $this->overrideService->approveLevel2($override, $request);

            return $this->success($result, 'level_2_approved');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    // ✅ 8. Reject
    public function reject(Request $request, DualApproval $override)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if (! in_array($override->status, ['pending', 'approved_level_1'])) {
            return $this->error('cannot_reject_this_override', 422);
        }

        $result = $this->overrideService->rejectOverride(
            $override,
            $request->reason,
            $request
        );

        return $this->success($result, 'override_rejected');
    }

    // ✅ 9. Execute
    public function execute(Request $request, DualApproval $override)
    {
        if ($override->status !== 'approved') {
            return $this->error('override_not_approved_yet', 422);
        }

        try {
            $result = $this->overrideService->executeOverride($override, $request);

            return $this->success($result, 'override_executed');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // ✅ 10. Audit Log
    public function auditLog()
    {
        $logs = ApprovalAuditLog::with([
            'dualApproval:id,action_type,payload',
            'actor:id,name',
        ])
            ->latest()
            ->paginate(20);

        return $this->success($logs, 'audit_log_fetched');
    }

    // ✅ 11. Export Immutable Log
    public function exportLog()
    {
        $logs = ApprovalAuditLog::with([
            'dualApproval',
            'actor:id,name',
        ])
            ->latest()
            ->get();

        $filename = 'override_audit_log_'.now()->format('Y_m_d_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Time', 'Actor', 'Event',
                'Action Type', 'Target',
                'Justification', 'IP Address',
            ]);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->actor?->name ?? 'Unknown',
                    $log->event,
                    $log->dualApproval?->action_type ?? 'N/A',
                    $log->dualApproval?->payload['target_entity_id'] ?? 'N/A',
                    $log->dualApproval?->justification ?? 'N/A',
                    $log->ip_address,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // ✅ 12. Reason Codes
    // public function getReasonCodes()
    // {
    //     $codes = OverrideReasonCode::get();
    //     dd($codes);

    //     return $this->success($codes, 'reason_codes_fetched');
    // }
    public function getReasonCodes()
    {
        $codes = OverrideReasonCode::get();

        return $this->success($codes, 'reason_codes_fetched');
    }
}

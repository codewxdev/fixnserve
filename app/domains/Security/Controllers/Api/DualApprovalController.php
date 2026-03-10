<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Command\Models\KillSwitch;
use App\Domains\Security\Models\ApprovalAuditLog;
use App\Domains\Security\Models\DualApproval;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DualApprovalController extends BaseApiController
{
    protected function logEvent($approvalId, $event, Request $request)
    {
        ApprovalAuditLog::create([
            'dual_approval_id' => $approvalId,
            'actor_id' => auth()->id(),
            'event' => $event,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    public function requestAction(Request $request)
    {
        $data = $request->validate([
            'action_type' => 'required|string',
            'payload' => 'required|array',
            'justification' => 'required|string',
        ]);

        $approval = DualApproval::create([
            'action_type' => $data['action_type'],
            'payload' => $data['payload'],
            'requested_by' => auth()->id(),
            'justification' => $data['justification'],
            'expires_at' => now()->addMinutes(30),
        ]);

        $this->logEvent($approval->id, 'requested', $request);

        return $this->success([
            'approval' => $approval,
        ], 'approval_request_created');
    }

    public function approveLevel1(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->requested_by == auth()->id()) {
            return $this->error('requester_cannot_approve', 403);
        }

        if ($approval->status !== 'pending') {
            return $this->error('invalid_approval_state', 400);
        }

        $approval->update([
            'status' => 'approved_level_1',
            'approved_by_level_1' => auth()->id(),
            'approved_at_level_1' => now(),
        ]);

        $this->logEvent($approval->id, 'approved_level_1', $request);

        return $this->success([], 'level1_approved');
    }

    public function approveLevel2(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->requested_by == auth()->id()) {
            return $this->error('requester_cannot_approve', 403);
        }

        if ($approval->approved_by_level_1 == auth()->id()) {
            return $this->error('same_approver_not_allowed', 403);
        }

        if ($approval->status !== 'approved_level_1') {
            return $this->error('invalid_approval_state', 400);
        }

        $approval->update([
            'status' => 'approved',
            'approved_by_level_2' => auth()->id(),
            'approved_at_level_2' => now(),
        ]);

        $this->logEvent($approval->id, 'approved_level_2', $request);

        return $this->success([], 'level2_approved');
    }

    public function execute(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->status !== 'approved') {
            return $this->error('approval_not_completed', 403);
        }

        DB::transaction(function () use ($approval) {

            switch ($approval->action_type) {

                case 'refund':
                    // $this->processRefund($approval->payload);
                    break;

                case 'payout':
                    // $this->processPayout($approval->payload);
                    break;

                case 'kill_switch':
                    $payload = $approval->payload;

                    KillSwitch::create([
                        'scope' => $payload['scope'],
                        'type' => $payload['type'],
                        'reason' => $payload['reason'],
                        'expires_at' => $payload['expires_at'],
                        'created_by' => $approval->requested_by,
                    ]);

                    break;
            }
        });

        $approval->update([
            'status' => 'executed',
        ]);

        $this->logEvent($approval->id, 'executed', $request);

        return $this->success([], 'action_executed');
    }

    public function auditApprovalLogs()
    {
        $logs = ApprovalAuditLog::with('dualApproval')->get();

        return $this->success([
            'logs' => $logs,
        ], 'approval_logs_fetched');
    }
}

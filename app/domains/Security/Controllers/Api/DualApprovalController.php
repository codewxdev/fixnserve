<?php

namespace App\Domains\Security\Controllers\Api;

use App\Domains\Command\Models\KillSwitch;
use App\Domains\Security\Models\ApprovalAuditLog;
use App\Domains\Security\Models\DualApproval;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DualApprovalController extends Controller
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

        return $approval;
    }

    public function approveLevel1(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->requested_by == auth()->id()) {
            return response()->json(['message' => 'Requester cannot approve'], 403);
        }

        if ($approval->status !== 'pending') {
            return response()->json(['message' => 'Invalid state'], 400);
        }

        $approval->update([
            'status' => 'approved_level_1',
            'approved_by_level_1' => auth()->id(),
            'approved_at_level_1' => now(),
        ]);

        $this->logEvent($approval->id, 'approved_level_1', $request);

        return response()->json(['message' => 'Level 1 approved']);
    }

    public function approveLevel2(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->requested_by == auth()->id()) {
            abort(403, 'Requester cannot approve');
        }

        if ($approval->approved_by_level_1 == auth()->id()) {
            abort(403, 'Same approver not allowed');
        }

        if ($approval->status !== 'approved_level_1') {
            abort(400, 'Invalid state');
        }

        $approval->update([
            'status' => 'approved',
            'approved_by_level_2' => auth()->id(),
            'approved_at_level_2' => now(),
        ]);

        $this->logEvent($approval->id, 'approved_level_2', $request);

        return response()->json(['message' => 'Fully approved']);
    }

    public function execute(Request $request, $id)
    {
        $request = DualApproval::findOrFail($id);

        if ($request->status !== 'approved') {
            abort(403, 'Not fully approved');
        }

        DB::transaction(function () use ($request) {
            switch ($request->action_type) {
                case 'refund':
                    // $this->processRefund($request->payload);
                    break;
                case 'payout':    // case 'payout':
                    // $this->processPayout($request->payload);
                    break;
                case 'kill_switch':
                    $payload = $request->payload;

                    KillSwitch::create([
                        'scope' => $payload['scope'],
                        'type' => $payload['type'],
                        'reason' => $payload['reason'],
                        'expires_at' => $payload['expires_at'],
                        'created_by' => $request->requested_by,
                    ]);

                    break;
            }
        });

        $request->update([
            'status' => 'executed',
        ]);

        $this->logEvent($request->id, 'executed', $request);

        return response()->json(['message' => 'Action executed']);
    }

    public function auditApprovalLogs()
    {
        $logs = ApprovalAuditLog::with('dualApproval')->get();

        return response()->json($logs);
    }
}

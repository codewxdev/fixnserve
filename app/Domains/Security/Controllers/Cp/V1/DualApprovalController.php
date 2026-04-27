<?php

namespace App\Domains\Security\Controllers\Cp\V1;

use App\Domains\Command\Models\KillSwitch;
use App\Domains\Security\Models\ApprovalAuditLog;
use App\Domains\Security\Models\DualApproval;
use App\Domains\System\Models\Geofence;
use App\Domains\System\Models\RateLimitConfiguration;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    // public function execute(Request $request, $id)
    // {
    //     $approval = DualApproval::findOrFail($id);

    //     if ($approval->status !== 'approved') {
    //         return $this->error('approval_not_completed', 403);
    //     }

    //     DB::transaction(function () use ($approval) {

    //         switch ($approval->action_type) {

    //             case 'refund':
    //                 // $this->processRefund($approval->payload);
    //                 break;

    //             case 'payout':
    //                 // $this->processPayout($approval->payload);
    //                 break;

    //             case 'kill_switch':
    //                 $payload = $approval->payload;

    //                 KillSwitch::create([
    //                     'scope' => $payload['scope'],
    //                     'type' => $payload['type'],
    //                     'reason' => $payload['reason'],
    //                     'expires_at' => $payload['expires_at'],
    //                     'created_by' => $approval->requested_by,
    //                 ]);

    //                 break;
    //         }
    //     });

    //     $approval->update([
    //         'status' => 'executed',
    //     ]);

    //     $this->logEvent($approval->id, 'executed', $request);

    //     return $this->success([], 'action_executed');
    // }

    public function execute(Request $request, $id)
    {
        $approval = DualApproval::findOrFail($id);

        if ($approval->status !== 'approved') {
            return $this->error('approval_not_completed', 403);
        }

        // ✅ Check expired
        if ($approval->expires_at && $approval->expires_at->isPast()) {
            $approval->update(['status' => 'expired']);

            return $this->error('approval_request_expired', 422);
        }

        DB::transaction(function () use ($approval, $request) {

            switch ($approval->action_type) {

                // ✅ Financial Settings change apply
                // case 'financial_settings':
                //     $this->applyFinancialSettings($approval->payload);
                //     break;

                // ✅ API Rate Limits change apply
                case 'api_rate_limits':
                    $this->applyRateLimits($approval->payload);
                    break;

                    // ✅ Geofence change apply
                case 'geofence_outages':
                    $this->applyGeofenceChanges($approval->payload);
                    break;

                    // ✅ Refund apply
                case 'refund':
                    $this->processRefund($approval->payload);
                    break;

                    // ✅ Kill switch apply
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

            // ✅ Mark as executed
            $approval->update(['status' => 'executed']);

            // ✅ Log it
            $this->logEvent($approval->id, 'executed', $request);
        });

        return $this->success([], 'action_executed');
    }

    // private function applyFinancialSettings(array $payload): void
    // {
    //     // Save to your financial config table
    //     FinancialConfiguration::updateOrCreate(
    //         ['id' => 1],
    //         $payload
    //     );

    //     Log::info('✅ Financial settings applied', $payload);
    // }

    // ✅ Apply rate limits
    private function applyRateLimits(array $payload): void
    {
        RateLimitConfiguration::updateOrCreate(
            ['id' => 1],
            $payload
        );

        // Clear cache so new limits apply instantly
        \Illuminate\Support\Facades\Cache::forget('rate_limit_config');

        Log::info('✅ Rate limits applied', $payload);
    }

    // ✅ Apply geofence changes
    private function applyGeofenceChanges(array $payload): void
    {
        if (isset($payload['geofence_id'])) {
            Geofence::find($payload['geofence_id'])
                ?->update($payload['changes']);
        } else {
            Geofence::create($payload);
        }

        // Clear geofence cache
        \Illuminate\Support\Facades\Cache::forget('geofences');

        Log::info('✅ Geofence changes applied', $payload);
    }

    // ✅ Process refund
    private function processRefund(array $payload): void
    {
        // Your refund logic here
        Log::info('✅ Refund processed', $payload);
    }

    public function auditApprovalLogs()
    {
        $logs = ApprovalAuditLog::with('dualApproval')->get();

        return $this->success([
            'logs' => $logs,
        ], 'approval_logs_fetched');
    }
}

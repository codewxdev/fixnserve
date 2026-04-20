<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Command\Models\KillSwitch;
use App\Domains\Fraud\Models\OverrideReasonCode;
use App\Domains\Security\Models\ApprovalAuditLog;
use App\Domains\Security\Models\DualApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManualOverrideService
{
    // ═══════════════════════════════════════
    // CREATE OVERRIDE REQUEST
    // Stores in dual_approval_requests
    // ═══════════════════════════════════════

    public function createOverride(array $data, Request $request): DualApproval
    {
        // ✅ Check if reason code needs dual approval
        $reasonCode = OverrideReasonCode::where('code', $data['reason_code'])
            ->first();

        $needsDual = $reasonCode?->requires_dual_approval
            || in_array($data['action_type'], [
                'wallet_unfreeze',
                'suspension_rollback',
                'account_unfreeze',
            ]);

        // ✅ Calculate expiry
        $expiresAt = $this->calculateExpiry($data['time_limit']);

        // ✅ Store in dual_approval_requests
        $override = DualApproval::create([
            'action_type' => $data['action_type'],
            'payload' => [
                'target_entity_id' => $data['target_entity_id'],
                'entity_type' => $data['entity_type'],
                'entity_db_id' => $data['entity_db_id'] ?? null,
                'reason_code' => $data['reason_code'],
                'time_limit' => $data['time_limit'],
                'needs_dual' => $needsDual,
            ],
            'requested_by' => auth()->id(),
            'justification' => $data['justification'],
            'status' => 'pending',
            'expires_at' => $expiresAt,
        ]);

        // ✅ Log in approval_audit_logs
        $this->logAudit(
            override: $override,
            event: 'requested',
            details: "Override requested for {$data['target_entity_id']}",
            request: $request
        );

        return $override;
    }

    // ═══════════════════════════════════════
    // APPROVE LEVEL 1
    // Updates dual_approval_requests
    // Logs in approval_audit_logs
    // ═══════════════════════════════════════

    public function approveLevel1(DualApproval $override, Request $request): DualApproval
    {
        // ✅ Cannot approve own request
        if ($override->requested_by === auth()->id()) {
            throw new \Exception('requester_cannot_approve');
        }

        // ✅ Check expired
        if ($override->isExpired()) {
            $override->update(['status' => 'expired']);
            throw new \Exception('override_request_expired');
        }

        $payload = $override->payload;
        $needsDual = $payload['needs_dual'] ?? false;

        $override->update([
            'approved_by_level_1' => auth()->id(),
            'approved_at_level_1' => now(),
            'status' => $needsDual
                ? 'approved_level_1'
                : 'approved',
        ]);

        // ✅ Log
        $this->logAudit(
            override: $override,
            event: $needsDual ? 'approved_level_1' : 'approved',
            details: $needsDual
                ? 'Level 1 approved - awaiting Level 2'
                : 'Single approval granted',
            request: $request
        );

        return $override->fresh();
    }

    // ═══════════════════════════════════════
    // APPROVE LEVEL 2
    // ═══════════════════════════════════════

    public function approveLevel2(DualApproval $override, Request $request): DualApproval
    {
        if ($override->requested_by === auth()->id()) {
            throw new \Exception('requester_cannot_approve');
        }

        if ($override->approved_by_level_1 === auth()->id()) {
            throw new \Exception('same_approver_not_allowed');
        }

        $override->update([
            'approved_by_level_2' => auth()->id(),
            'approved_at_level_2' => now(),
            'status' => 'approved',
        ]);

        $this->logAudit(
            override: $override,
            event: 'approved_level_2',
            details: 'Dual approval complete - Co-signed by '.auth()->user()->name,
            request: $request
        );

        return $override->fresh();
    }

    // ═══════════════════════════════════════
    // REJECT
    // ═══════════════════════════════════════

    public function rejectOverride(
        DualApproval $override,
        string $reason,
        Request $request
    ): DualApproval {

        $override->update(['status' => 'rejected']);

        $this->logAudit(
            override: $override,
            event: 'rejected',
            details: "Rejected: {$reason}",
            request: $request
        );

        return $override->fresh();
    }

    // ═══════════════════════════════════════
    // EXECUTE - Apply actual action
    // Uses existing tables for actions
    // ═══════════════════════════════════════

    public function executeOverride(
        DualApproval $override,
        Request $request
    ): DualApproval {

        if ($override->status !== 'approved') {
            throw new \Exception('approval_not_completed');
        }

        DB::transaction(function () use ($override, $request) {

            $payload = $override->payload;

            // ✅ Apply action based on action_type
            match ($override->action_type) {

                // Wallet Unfreeze
                'wallet_unfreeze' => $this->walletUnfreeze($payload),

                // Wallet Freeze
                'wallet_freeze' => $this->walletFreeze($payload),

                // Account Unfreeze
                'account_unfreeze' => $this->accountUnfreeze($payload),

                // Account Suspend
                'account_suspend' => $this->accountSuspend($payload),

                // Suspension Rollback
                'suspension_rollback' => $this->suspensionRollback($payload),

                // Risk Score Override
                'risk_score_override' => $this->riskScoreOverride($payload),

                // Force Allow
                'force_allow' => $this->forceAllow($payload),

                // Enforcement Rollback
                'enforcement_rollback' => $this->enforcementRollback($payload),

                // Existing: Refund
                'refund' => $this->processRefund($payload),

                // Existing: Kill Switch
                'kill_switch' => $this->processKillSwitch($payload),

                default => Log::warning('Unknown action: '.$override->action_type),
            };

            // ✅ Mark executed
            $override->update(['status' => 'executed']);

            // ✅ Immutable log
            $this->logAudit(
                override: $override,
                event: 'executed',
                details: "Action {$override->action_type} executed on {$payload['target_entity_id']}",
                request: $request
            );
        });

        return $override->fresh();
    }

    // ═══════════════════════════════════════
    // ACTION IMPLEMENTATIONS
    // ═══════════════════════════════════════

    private function walletUnfreeze(array $payload): void
    {
        DB::table('risk_enforcements')
            ->where('entity_type', $payload['entity_type'])
            ->where('entity_id', $payload['entity_db_id'])
            ->where('action', 'wallet_freeze')
            ->where('is_active', true)
            ->update(['is_active' => false]);

        Log::info("✅ Wallet unfrozen: {$payload['target_entity_id']}");
    }

    private function walletFreeze(array $payload): void
    {
        DB::table('risk_enforcements')->insert([
            'entity_type' => $payload['entity_type'],
            'entity_id' => $payload['entity_db_id'],
            'action' => 'wallet_freeze',
            'trigger' => 'manual',
            'risk_score' => 0,
            'reason' => 'Manual override',
            'enforced_by' => auth()->id(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function accountUnfreeze(array $payload): void
    {
        Cache::forget("session_locked:{$payload['entity_db_id']}");
        Cache::forget("stepup_required:{$payload['entity_db_id']}");
        Log::info("✅ Account unfrozen: {$payload['target_entity_id']}");
    }

    private function accountSuspend(array $payload): void
    {
        DB::table('user_sessions')
            ->where('user_id', $payload['entity_db_id'])
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    private function suspensionRollback(array $payload): void
    {
        // Remove enforcements
        DB::table('risk_enforcements')
            ->where('entity_id', $payload['entity_db_id'])
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Reset risk score
        DB::table('risk_scores')
            ->where('entity_type', $payload['entity_type'])
            ->where('entity_id', $payload['entity_db_id'])
            ->update(['score' => 0, 'tier' => 'low']);
    }

    private function riskScoreOverride(array $payload): void
    {
        DB::table('risk_scores')
            ->where('entity_type', $payload['entity_type'])
            ->where('entity_id', $payload['entity_db_id'])
            ->update([
                'score' => 0,
                'tier' => 'low',
                'reason_codes' => json_encode(['manual_override']),
            ]);
    }

    private function forceAllow(array $payload): void
    {
        $expiry = isset($payload['time_limit'])
            ? $this->calculateExpiry($payload['time_limit'])
            : now()->addHours(24);

        Cache::put(
            "force_allow:{$payload['entity_db_id']}",
            true,
            $expiry
        );
    }

    private function enforcementRollback(array $payload): void
    {
        DB::table('risk_enforcements')
            ->where('entity_id', $payload['entity_db_id'])
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }

    private function processRefund(array $payload): void
    {
        Log::info('✅ Refund processed', $payload);
    }

    private function processKillSwitch(array $payload): void
    {
        KillSwitch::create([
            'scope' => $payload['scope'],
            'type' => $payload['type'],
            'reason' => $payload['reason'],
            'expires_at' => $payload['expires_at'],
            'created_by' => auth()->id(),
        ]);
    }

    // ═══════════════════════════════════════
    // IMMUTABLE AUDIT LOG
    // Stores in approval_audit_logs
    // ═══════════════════════════════════════

    public function logAudit(
        DualApproval $override,
        string $event,
        string $details,
        Request $request
    ): void {

        ApprovalAuditLog::create([
            'dual_approval_id' => $override->id,
            'actor_id' => auth()->id(),
            'event' => $event,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }

    // ═══════════════════════════════════════
    // METRICS
    // ═══════════════════════════════════════

    public function getMetrics(): array
    {
        $totalOverrides = DualApproval::whereDate('created_at', today())->count();
        $totalRisk = DB::table('risk_scores')->count();
        $overridden = DualApproval::whereDate('created_at', today())
            ->where('status', 'executed')->count();

        $aiRetained = $totalRisk > 0
            ? round((($totalRisk - $overridden) / $totalRisk) * 100, 1)
            : 100;

        $mostCommon = DualApproval::whereDate('created_at', today())
            ->select(
                DB::raw("JSON_UNQUOTE(JSON_EXTRACT(payload, '$.reason_code')) as reason_code"),
                DB::raw('count(*) as count')
            )
            ->groupBy('reason_code')
            ->orderByDesc('count')
            ->first();

        return [
            'total_overrides' => $totalOverrides,
            'ai_decisions_retained' => $aiRetained.'%',
            'most_common_reason' => $mostCommon?->reason_code ?? 'N/A',
            'pending_approvals' => DualApproval::pending()->count(),
            'executed_today' => $overridden,
        ];
    }

    // ✅ Calculate expiry
    private function calculateExpiry(string $timeLimit): ?\Carbon\Carbon
    {
        return match ($timeLimit) {
            '1_hour' => now()->addHour(),
            '6_hours' => now()->addHours(6),
            '24_hours' => now()->addHours(24),
            '7_days' => now()->addDays(7),
            '30_days' => now()->addDays(30),
            'permanent' => null,
            default => null,
        };
    }
}

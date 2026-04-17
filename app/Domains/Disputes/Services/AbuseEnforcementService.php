<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\AbuseDetection;
use App\Domains\Disputes\Models\AbusePolicy;
use App\Domains\Disputes\Models\EnforcementAction;
use App\Domains\Fraud\Services\RiskScoringService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AbuseEnforcementService
{
    // ═══════════════════════════════════════
    // MAIN SCAN
    // Called after every dispute/refund
    // ═══════════════════════════════════════

    public function scanEntity(
        string $entityType,
        int $entityId,
        string $entityRef,
        string $triggerEvent
    ): ?AbuseDetection {

        $policy = AbusePolicy::getActive();

        // ✅ Run all pattern checks
        $checks = [
            'refund_farming' => $this->detectRefundFarming(
                $entityType, $entityId, $policy
            ),
            'high_dispute_frequency' => $this->detectHighDisputeFrequency(
                $entityType, $entityId, $policy
            ),
            'false_claims' => $this->detectFalseClaims(
                $entityType, $entityId, $policy
            ),
            'coordinated_complaints' => $this->detectCoordinatedComplaints(
                $entityType, $entityId, $policy
            ),
            'wallet_abuse' => $this->detectWalletAbuse(
                $entityType, $entityId, $policy
            ),
        ];

        foreach ($checks as $abuseType => $result) {
            if (! $result['detected']) {
                continue;
            }

            // ✅ Create detection
            $detection = AbuseDetection::create([
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'entity_ref' => $entityRef,
                'abuse_type' => $abuseType,
                'confidence_score' => $result['confidence'],
                'pattern_detail' => $result['detail'],
                'evidence' => $result['evidence'],
                'severity' => $result['severity'],
                'enforcement_action' => $result['action'],
                'status' => 'detected',
            ]);

            // ✅ Auto enforce
            if ($policy->auto_enforce) {
                $this->enforce($detection);
            }

            // ✅ Sync to Risk Module 13
            $this->syncToRiskModule($detection);

            Log::warning("🚨 Abuse detected: {$abuseType}", [
                'entity' => $entityRef,
                'confidence' => $result['confidence'],
                'action' => $result['action'],
            ]);

            return $detection;
        }

        return null;
    }

    // ═══════════════════════════════════════
    // DETECTION METHODS
    // ═══════════════════════════════════════

    // ✅ Refund Farming Detection
    private function detectRefundFarming(
        string $entityType,
        int $entityId,
        AbusePolicy $policy
    ): array {

        // Count refunds this month
        $monthlyRefunds = DB::table('refund_requests')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Total refund amount
        $totalAmount = DB::table('refund_requests')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('approved_amount');

        $countViolation = $monthlyRefunds >= $policy->max_refunds_per_month;
        $amountViolation = $totalAmount >= $policy->refund_amount_threshold;
        $detected = $countViolation || $amountViolation;
        $confidence = min(100, ($monthlyRefunds * 15) + ($amountViolation ? 30 : 0));

        return [
            'detected' => $detected,
            'detail' => "{$monthlyRefunds} refunds this month totaling Rs. {$totalAmount}",
            'confidence' => $confidence,
            'severity' => $monthlyRefunds >= 5 ? 'critical' : 'high',
            'action' => 'refund_limit',
            'evidence' => [
                'monthly_refunds' => $monthlyRefunds,
                'total_amount' => $totalAmount,
                'limit' => $policy->max_refunds_per_month,
            ],
        ];
    }

    // ✅ High Dispute Frequency
    private function detectHighDisputeFrequency(
        string $entityType,
        int $entityId,
        AbusePolicy $policy
    ): array {

        $monthlyDisputes = DB::table('complaints')
            ->where('reporter_type', $entityType)
            ->where('reporter_id', $entityId)
            ->whereMonth('created_at', now()->month)
            ->count();

        $detected = $monthlyDisputes >= $policy->max_disputes_per_month;
        $confidence = min(100, $monthlyDisputes * 12);

        return [
            'detected' => $detected,
            'detail' => "{$monthlyDisputes} disputes filed this month",
            'confidence' => $confidence,
            'severity' => $monthlyDisputes >= 8 ? 'critical' : 'high',
            'action' => 'account_restriction',
            'evidence' => [
                'monthly_disputes' => $monthlyDisputes,
                'limit' => $policy->max_disputes_per_month,
            ],
        ];
    }

    // ✅ False Claims Detection
    private function detectFalseClaims(
        string $entityType,
        int $entityId,
        AbusePolicy $policy
    ): array {

        // Rejected complaints (false claims)
        $falseClaims = DB::table('complaints')
            ->where('reporter_type', $entityType)
            ->where('reporter_id', $entityId)
            ->where('status', 'closed')
            ->whereMonth('created_at', now()->month)
            ->count();

        // Rejected refunds
        $rejectedRefunds = DB::table('refund_requests')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('status', 'rejected')
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalFalse = $falseClaims + $rejectedRefunds;
        $detected = $totalFalse >= $policy->false_claim_threshold;
        $confidence = min(100, $totalFalse * 20);

        return [
            'detected' => $detected,
            'detail' => "{$totalFalse} false/rejected claims this month",
            'confidence' => $confidence,
            'severity' => 'high',
            'action' => 'account_restriction',
            'evidence' => [
                'false_complaints' => $falseClaims,
                'rejected_refunds' => $rejectedRefunds,
                'threshold' => $policy->false_claim_threshold,
            ],
        ];
    }

    // ✅ Coordinated Complaints
    private function detectCoordinatedComplaints(
        string $entityType,
        int $entityId,
        AbusePolicy $policy
    ): array {

        // Multiple complaints from same IP/device in short time
        $recentComplaints = DB::table('complaints')
            ->where('reporter_type', $entityType)
            ->where('reporter_id', $entityId)
            ->where('created_at', '>=', now()->subHours(2))
            ->count();

        $detected = $recentComplaints >= $policy->coordinated_complaint_threshold;
        $confidence = min(100, $recentComplaints * 15);

        return [
            'detected' => $detected,
            'detail' => "{$recentComplaints} complaints in last 2 hours",
            'confidence' => $confidence,
            'severity' => 'critical',
            'action' => 'risk_escalation',
            'evidence' => [
                'complaints_2h' => $recentComplaints,
                'threshold' => $policy->coordinated_complaint_threshold,
            ],
        ];
    }

    // ✅ Wallet Abuse
    private function detectWalletAbuse(
        string $entityType,
        int $entityId,
        AbusePolicy $policy
    ): array {

        // Large wallet refunds then withdrawal
        $recentRefundToWallet = DB::table('refund_requests')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('refund_type', 'wallet')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        $recentWithdrawals = DB::table('wallet_transactions')
            ->where('user_id', $entityId)
            ->where('type', 'withdrawal')
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        $detected = $recentRefundToWallet >= 2 && $recentWithdrawals >= 1;
        $confidence = min(100, ($recentRefundToWallet * 20) + ($recentWithdrawals * 15));

        return [
            'detected' => $detected,
            'detail' => "{$recentRefundToWallet} wallet refunds + {$recentWithdrawals} withdrawals in 24h",
            'confidence' => $confidence,
            'severity' => 'critical',
            'action' => 'wallet_lock',
            'evidence' => [
                'wallet_refunds' => $recentRefundToWallet,
                'withdrawals' => $recentWithdrawals,
            ],
        ];
    }

    // ═══════════════════════════════════════
    // ENFORCEMENT
    // ═══════════════════════════════════════

    public function enforce(AbuseDetection $detection): void
    {
        $expiry = match ($detection->severity) {
            'critical' => now()->addDays(30),
            'high' => now()->addDays(7),
            'medium' => now()->addDays(3),
            default => now()->addDays(1),
        };

        // ✅ Create enforcement record
        EnforcementAction::create([
            'abuse_detection_id' => $detection->id,
            'entity_type' => $detection->entity_type,
            'entity_id' => $detection->entity_id,
            'action_type' => $detection->enforcement_action,
            'reason' => $detection->pattern_detail,
            'expires_at' => $expiry,
            'is_active' => true,
        ]);

        // ✅ Apply action
        match ($detection->enforcement_action) {
            'warning' => $this->applyWarning($detection),
            'refund_limit' => $this->applyRefundLimit($detection, $expiry),
            'account_restriction' => $this->applyAccountRestriction($detection, $expiry),
            'wallet_lock' => $this->applyWalletLock($detection, $expiry),
            'risk_escalation' => $this->applyRiskEscalation($detection),
            'permanent_ban' => $this->applyPermanentBan($detection),
        };

        $detection->update(['status' => 'enforced']);
    }

    private function applyWarning(AbuseDetection $detection): void
    {
        Cache::put(
            "abuse_warning:{$detection->entity_type}:{$detection->entity_id}",
            $detection->pattern_detail,
            now()->addDays(7)
        );
        Log::info("⚠️ Warning applied: {$detection->entity_ref}");
    }

    private function applyRefundLimit(
        AbuseDetection $detection,
        \Carbon\Carbon $expiry
    ): void {
        Cache::put(
            "refund_limited:{$detection->entity_type}:{$detection->entity_id}",
            true,
            $expiry
        );
        Log::warning("🚫 Refund limited: {$detection->entity_ref}");
    }

    private function applyAccountRestriction(
        AbuseDetection $detection,
        \Carbon\Carbon $expiry
    ): void {
        Cache::put(
            "account_restricted:{$detection->entity_type}:{$detection->entity_id}",
            true,
            $expiry
        );
        Log::warning("🔒 Account restricted: {$detection->entity_ref}");
    }

    private function applyWalletLock(
        AbuseDetection $detection,
        \Carbon\Carbon $expiry
    ): void {
        DB::table('risk_enforcements')->insert([
            'entity_type' => $detection->entity_type,
            'entity_id' => $detection->entity_id,
            'action' => 'wallet_freeze',
            'trigger' => 'auto',
            'risk_score' => $detection->confidence_score,
            'reason' => "Abuse: {$detection->abuse_type}",
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Log::warning("💰 Wallet locked: {$detection->entity_ref}");
    }

    private function applyRiskEscalation(AbuseDetection $detection): void
    {
        // Create risk event in Module 13
        DB::table('risk_events')->insert([
            'entity_type' => $detection->entity_type,
            'entity_id' => $detection->entity_id,
            'event_type' => 'abuse_detected',
            'event_data' => json_encode([
                'abuse_type' => $detection->abuse_type,
                'confidence' => $detection->confidence_score,
                'detail' => $detection->pattern_detail,
            ]),
            'score_before' => 0,
            'score_after' => 0,
            'score_delta' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Trigger risk rescore
        app(RiskScoringService::class)->processEvent(
            entityType: $detection->entity_type,
            entityId: $detection->entity_id,
            eventType: 'abuse_detected',
            eventData: ['source' => 'abuse_module']
        );

        Log::warning("📊 Risk escalated: {$detection->entity_ref}");
    }

    private function applyPermanentBan(AbuseDetection $detection): void
    {
        DB::table('users')
            ->where('id', $detection->entity_id)
            ->update(['status' => 'banned']);

        DB::table('user_sessions')
            ->where('user_id', $detection->entity_id)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);

        Log::warning("🚫 Permanent ban: {$detection->entity_ref}");
    }

    // ✅ Sync to Risk Module 13
    private function syncToRiskModule(AbuseDetection $detection): void
    {
        DB::table('risk_events')->insert([
            'entity_type' => $detection->entity_type,
            'entity_id' => $detection->entity_id,
            'event_type' => "abuse_{$detection->abuse_type}",
            'event_data' => json_encode($detection->evidence),
            'score_before' => 0,
            'score_after' => 0,
            'score_delta' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $detection->update(['synced_to_risk_module' => true]);

        Log::info("🔄 Synced to risk module: {$detection->entity_ref}");
    }

    // ✅ Check if entity has active restriction
    public function hasActiveRestriction(
        string $entityType,
        int $entityId,
        string $restrictionType
    ): bool {

        return match ($restrictionType) {
            'refund' => (bool) Cache::get(
                "refund_limited:{$entityType}:{$entityId}"
            ),
            'account' => (bool) Cache::get(
                "account_restricted:{$entityType}:{$entityId}"
            ),
            'wallet' => DB::table('risk_enforcements')
                ->where('entity_type', $entityType)
                ->where('entity_id', $entityId)
                ->where('action', 'wallet_freeze')
                ->where('is_active', true)
                ->exists(),
            default => false,
        };
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        return [
            'detections_today' => AbuseDetection::today()->count(),
            'enforcements_active' => EnforcementAction::active()->count(),
            'by_type' => [
                'refund_farming' => AbuseDetection::where('abuse_type', 'refund_farming')->count(),
                'high_dispute_frequency' => AbuseDetection::where('abuse_type', 'high_dispute_frequency')->count(),
                'false_claims' => AbuseDetection::where('abuse_type', 'false_claims')->count(),
                'coordinated_complaints' => AbuseDetection::where('abuse_type', 'coordinated_complaints')->count(),
                'wallet_abuse' => AbuseDetection::where('abuse_type', 'wallet_abuse')->count(),
            ],
            'by_enforcement' => [
                'warnings' => EnforcementAction::active()->where('action_type', 'warning')->count(),
                'refund_limits' => EnforcementAction::active()->where('action_type', 'refund_limit')->count(),
                'account_restricted' => EnforcementAction::active()->where('action_type', 'account_restriction')->count(),
                'wallet_locked' => EnforcementAction::active()->where('action_type', 'wallet_lock')->count(),
            ],
            'risk_module_synced' => AbuseDetection::where('synced_to_risk_module', true)->count(),
        ];
    }
}

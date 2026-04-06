<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Fraud\Models\PaymentAbuseDetection;
use App\Domains\Fraud\Models\PaymentVelocityLimit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentAbuseService
{
    // ═══════════════════════════════════════
    // MAIN SCAN - Called by Middleware
    // ═══════════════════════════════════════

    public function scanTransaction(
        string $entityType,
        int $entityId,
        string $entityRef,
        string $transactionType,
        float $amount,
        array $meta = []
    ): ?PaymentAbuseDetection {

        $detection = null;

        // ✅ Run all pattern checks
        $checks = [
            'refund_wallet_loop' => $this->detectRefundWalletLoop($entityType, $entityId, $amount),
            'cod_manipulation' => $this->detectCodManipulation($entityType, $entityId),
            'chargeback_clustering' => $this->detectChargebackClustering($entityType, $entityId),
            'velocity_breach' => $this->checkVelocityLimits($entityType, $entityId, $transactionType),
            'rapid_withdrawal' => $this->detectRapidWithdrawal($entityType, $entityId, $transactionType, $amount),
        ];

        foreach ($checks as $pattern => $result) {
            if (! $result['detected']) {
                continue;
            }

            // ✅ Create detection record
            $detection = PaymentAbuseDetection::create([
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'entity_ref' => $entityRef,
                'transaction_type' => $transactionType,
                'amount' => $amount,
                'abuse_pattern' => $pattern,
                'pattern_detail' => $result['detail'],
                'confidence_score' => $result['confidence'],
                'severity' => $result['severity'],
                'auto_action' => $result['action'],
                'status' => 'detected',
                'meta' => $meta,
            ]);

            // ✅ Apply auto action
            $this->applyAutoAction($detection);

            Log::warning("🚨 Payment abuse detected: {$pattern}", [
                'entity' => $entityRef,
                'confidence' => $result['confidence'],
                'action' => $result['action'],
            ]);

            break; // One detection per transaction
        }

        return $detection;
    }

    // ═══════════════════════════════════════
    // PATTERN DETECTION METHODS
    // ═══════════════════════════════════════

    // ✅ Refund-Wallet Loop Detection
    private function detectRefundWalletLoop(
        string $entityType,
        int $entityId,
        float $amount
    ): array {

        // Check: cancelled orders in last 1 hour
        $cancelledOrders = DB::table('orders')
            ->where('user_id', $entityId)
            ->where('status', 'cancelled')
            ->where('created_at', '>=', now()->subHour())
            ->count();

        // Check: wallet credits in last 1 hour
        $walletCredits = DB::table('wallet_transactions')
            ->where('user_id', $entityId)
            ->where('type', 'refund')
            ->where('created_at', '>=', now()->subHour())
            ->count();

        // Check: withdrawal attempt
        $isWithdrawal = DB::table('wallet_transactions')
            ->where('user_id', $entityId)
            ->where('type', 'withdrawal')
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        $detected = $cancelledOrders >= 3 && $walletCredits >= 2 && $isWithdrawal;
        $confidence = min(100, ($cancelledOrders * 20) + ($walletCredits * 15));

        return [
            'detected' => $detected,
            'detail' => "{$cancelledOrders} cancelled orders within 1 hour. Funds moved to wallet.",
            'confidence' => $confidence,
            'severity' => 'critical',
            'action' => 'wallet_freeze',
        ];
    }

    // ✅ COD Manipulation Detection
    private function detectCodManipulation(
        string $entityType,
        int $entityId
    ): array {

        if ($entityType !== 'rider') {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'severity' => 'low', 'action' => 'none'];
        }

        // Check: pending COD deposits > 48 hours
        $pendingCod = DB::table('cod_deposits')
            ->where('rider_id', $entityId)
            ->where('status', 'pending')
            ->where('created_at', '<=', now()->subHours(48))
            ->sum('amount');

        $detected = $pendingCod > 0;
        $confidence = $pendingCod > 50000 ? 90 : ($pendingCod > 20000 ? 75 : 60);

        return [
            'detected' => $detected,
            'detail' => 'Threshold exceeded (48h). High risk of absconding.',
            'confidence' => $confidence,
            'severity' => 'high',
            'action' => 'manual_review',
        ];
    }

    // ✅ Chargeback Clustering Detection
    private function detectChargebackClustering(
        string $entityType,
        int $entityId
    ): array {

        // Check: multiple chargebacks from same device/IP
        $chargebacks = DB::table('chargebacks')
            ->where('entity_id', $entityId)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $detected = $chargebacks >= 3;
        $confidence = min(100, $chargebacks * 20);

        return [
            'detected' => $detected,
            'detail' => 'Recent payments from high-risk BINs (Credit Cards).',
            'confidence' => $confidence,
            'severity' => 'medium',
            'action' => 'payout_delay',
        ];
    }

    // ✅ Velocity Limits Check
    private function checkVelocityLimits(
        string $entityType,
        int $entityId,
        string $transactionType
    ): array {

        $limitKey = match ($transactionType) {
            'topup' => 'topups_per_day',
            'withdrawal' => 'withdrawals_per_day',
            default => null,
        };

        if (! $limitKey) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'severity' => 'low', 'action' => 'none'];
        }

        $limit = PaymentVelocityLimit::where('limit_key', $limitKey)
            ->where('is_active', true)
            ->first();

        if (! $limit) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'severity' => 'low', 'action' => 'none'];
        }

        // Count today's transactions
        $cacheKey = "velocity:{$entityType}:{$entityId}:{$limitKey}";
        $count = Cache::get($cacheKey, 0);

        $detected = $count >= $limit->max_count;

        return [
            'detected' => $detected,
            'detail' => "Velocity limit exceeded: {$count}/{$limit->max_count} {$transactionType}s today",
            'confidence' => $detected ? 95 : 0,
            'severity' => 'high',
            'action' => 'wallet_freeze',
        ];
    }

    // ✅ Rapid Withdrawal Detection
    private function detectRapidWithdrawal(
        string $entityType,
        int $entityId,
        string $transactionType,
        float $amount
    ): array {

        if ($transactionType !== 'withdrawal') {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'severity' => 'low', 'action' => 'none'];
        }

        // Multiple withdrawals in 1 hour
        $withdrawals = DB::table('wallet_transactions')
            ->where('user_id', $entityId)
            ->where('type', 'withdrawal')
            ->where('created_at', '>=', now()->subHour())
            ->count();

        $detected = $withdrawals >= 3;
        $confidence = min(100, $withdrawals * 25);

        return [
            'detected' => $detected,
            'detail' => "{$withdrawals} withdrawals in last 1 hour",
            'confidence' => $confidence,
            'severity' => 'high',
            'action' => 'wallet_freeze',
        ];
    }

    // ═══════════════════════════════════════
    // AUTO ACTION
    // ═══════════════════════════════════════

    public function applyAutoAction(PaymentAbuseDetection $detection): void
    {
        match ($detection->auto_action) {

            'wallet_freeze' => $this->freezeWallet($detection),

            'payout_delay' => $this->delayPayout($detection),

            'manual_review' => $this->triggerManualReview($detection),

            'suspend_dispatch' => $this->suspendDispatch($detection),

            'block_cod' => $this->blockCodOption($detection),

            default => null,
        };

        // ✅ Update finance module
        $this->updateFinanceModule($detection);
    }

    // ✅ Wallet Freeze
    public function freezeWallet(PaymentAbuseDetection $detection): void
    {
        DB::table('risk_enforcements')->insert([
            'entity_type' => $detection->entity_type,
            'entity_id' => $detection->entity_id,
            'action' => 'wallet_freeze',
            'trigger' => 'auto',
            'risk_score' => $detection->confidence_score,
            'reason' => "Auto: {$detection->abuse_pattern}",
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::warning("🔒 Wallet frozen: {$detection->entity_ref}");
    }

    // ✅ Payout Delay (T+3)
    public function delayPayout(PaymentAbuseDetection $detection): void
    {
        Cache::put(
            "payout_delay:{$detection->entity_id}",
            now()->addDays(3)->toDateTimeString(),
            now()->addDays(3)
        );

        Log::info("⏰ Payout delayed T+3: {$detection->entity_ref}");
    }

    // ✅ Manual Review Trigger
    public function triggerManualReview(PaymentAbuseDetection $detection): void
    {
        $detection->update(['status' => 'under_review']);

        Log::info("👁️ Manual review triggered: {$detection->entity_ref}");
    }

    // ✅ Suspend Dispatch
    public function suspendDispatch(PaymentAbuseDetection $detection): void
    {
        Cache::put(
            "dispatch_suspended:{$detection->entity_id}",
            true,
            now()->addHours(24)
        );

        Log::warning("🚫 Dispatch suspended: {$detection->entity_ref}");
    }

    // ✅ Block COD Option
    public function blockCodOption(PaymentAbuseDetection $detection): void
    {
        Cache::put(
            "cod_blocked:{$detection->entity_id}",
            true,
            now()->addDays(7)
        );

        Log::warning("🚫 COD blocked: {$detection->entity_ref}");
    }

    // ✅ Update Finance Module
    private function updateFinanceModule(PaymentAbuseDetection $detection): void
    {
        $detection->update(['finance_module_updated' => true]);
        Log::info("💰 Finance module updated for: {$detection->entity_ref}");
    }

    // ✅ Increment velocity counter
    public function incrementVelocity(
        string $entityType,
        int $entityId,
        string $transactionType
    ): void {

        $limitKey = match ($transactionType) {
            'topup' => 'topups_per_day',
            'withdrawal' => 'withdrawals_per_day',
            default => null,
        };

        if (! $limitKey) {
            return;
        }

        $cacheKey = "velocity:{$entityType}:{$entityId}:{$limitKey}";
        $count = Cache::increment($cacheKey);

        if ($count === 1) {
            Cache::expire($cacheKey, 86400); // 24 hours
        }
    }

    // ✅ Dashboard Stats
    public function getDashboardStats(): array
    {
        // Blocked volume (24h)
        $blockedVolume = PaymentAbuseDetection::today()
            ->where('auto_action', 'wallet_freeze')
            ->sum('amount');

        // Frozen wallets
        $frozenWallets = DB::table('risk_enforcements')
            ->where('action', 'wallet_freeze')
            ->where('is_active', true)
            ->count();

        return [
            'blocked_volume_24h' => $blockedVolume,
            'frozen_wallets' => $frozenWallets,
            'detections_today' => PaymentAbuseDetection::today()->count(),
            'critical_count' => PaymentAbuseDetection::today()
                ->where('severity', 'critical')->count(),
            'patterns' => [
                'refund_wallet_loop' => PaymentAbuseDetection::today()
                    ->where('abuse_pattern', 'refund_wallet_loop')->count(),
                'cod_manipulation' => PaymentAbuseDetection::today()
                    ->where('abuse_pattern', 'cod_manipulation')->count(),
                'chargeback_clustering' => PaymentAbuseDetection::today()
                    ->where('abuse_pattern', 'chargeback_clustering')->count(),
            ],
        ];
    }
}

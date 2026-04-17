<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Fraud\Models\PromoAbuseDetection;
use App\Domains\Fraud\Models\PromoUsageLog;
use App\Domains\Fraud\Models\ReferralGraph;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PromoAbuseService
{
    // ═══════════════════════════════════════
    // MAIN SCAN
    // ═══════════════════════════════════════

    public function scanPromoAttempt(
        string $entityType,
        int $entityId,
        string $entityRef,
        string $promoCode,
        string $promoType,
        float $promoAmount,
        array $meta = []
    ): array {

        $checks = [
            'self_referral' => $this->detectSelfReferral($entityId, $promoCode, $meta),
            'fake_interaction' => $this->detectFakeInteraction($entityType, $entityId, $meta),
            'promo_stacking' => $this->detectPromoStacking($entityId, $promoCode, $meta),
            'multiple_accounts_device' => $this->detectMultipleAccountsDevice($entityId, $meta),
            'new_user_old_card' => $this->detectNewUserOldCard($entityId, $meta),
            'velocity_abuse' => $this->detectVelocityAbuse($entityId, $promoType),
        ];

        foreach ($checks as $pattern => $result) {
            if (! $result['detected']) {
                continue;
            }

            // ✅ Create detection
            $detection = PromoAbuseDetection::create([
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'entity_ref' => $entityRef,
                'promo_code' => $promoCode,
                'promo_type' => $promoType,
                'promo_amount' => $promoAmount,
                'abuse_pattern' => $pattern,
                'pattern_detail' => $result['detail'],
                'confidence_score' => $result['confidence'],
                'system_action' => $result['action'],
                'status' => 'detected',
                'meta' => $meta,
            ]);

            // ✅ Log promo usage as blocked
            PromoUsageLog::create([
                'user_id' => $entityId,
                'promo_code' => $promoCode,
                'device_hash' => $meta['device_hash'] ?? null,
                'ip_address' => $meta['ip_address'] ?? null,
                'was_blocked' => true,
                'block_reason' => $pattern,
            ]);

            // ✅ Apply action
            $this->applySystemAction($detection, $promoAmount);

            Log::warning("🚨 Promo abuse: {$pattern}", [
                'entity' => $entityRef,
                'promo' => $promoCode,
                'confidence' => $result['confidence'],
            ]);

            return [
                'allowed' => false,
                'reason' => $pattern,
                'action' => $result['action'],
                'detection' => $detection,
            ];
        }

        // ✅ No abuse - log valid usage
        PromoUsageLog::create([
            'user_id' => $entityId,
            'promo_code' => $promoCode,
            'device_hash' => $meta['device_hash'] ?? null,
            'ip_address' => $meta['ip_address'] ?? null,
            'was_blocked' => false,
        ]);

        return ['allowed' => true];
    }

    // ═══════════════════════════════════════
    // DETECTION METHODS
    // ═══════════════════════════════════════

    // ✅ Self Referral Detection
    private function detectSelfReferral(
        int $entityId,
        string $promoCode,
        array $meta
    ): array {

        // Find who owns this referral code
        $referrer = DB::table('users')
            ->where('referral_code', $promoCode)
            ->first();

        if (! $referrer) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        // Self referral
        if ($referrer->id === $entityId) {
            return [
                'detected' => true,
                'detail' => 'User attempting to use own referral code.',
                'confidence' => 100,
                'action' => 'promo_invalidated',
                'severity' => 'critical',
            ];
        }

        // Same device hash check
        $sameDevice = $meta['device_hash'] &&
            DB::table('devices')
                ->where('fingerprint', $meta['device_hash'])
                ->whereIn('user_id', [$referrer->id, $entityId])
                ->distinct('user_id')
                ->count('user_id') > 1;

        // Same IP check
        $sameIp = $meta['ip_address'] &&
            DB::table('user_sessions')
                ->whereIn('user_id', [$referrer->id, $entityId])
                ->where('ip_address', $meta['ip_address'])
                ->distinct('user_id')
                ->count('user_id') > 1;

        $detected = $sameDevice || $sameIp;

        if ($detected) {
            // ✅ Update referral graph
            ReferralGraph::updateOrCreate(
                ['referrer_id' => $referrer->id, 'referee_id' => $entityId],
                [
                    'device_hash' => $meta['device_hash'] ?? null,
                    'ip_address' => $meta['ip_address'] ?? null,
                    'same_device' => $sameDevice,
                    'same_ip' => $sameIp,
                    'is_suspicious' => true,
                    'status' => 'suspicious',
                ]
            );
        }

        return [
            'detected' => $detected,
            'detail' => 'Inviter and Invitee share exact same Device Hash & IP Address.',
            'confidence' => $sameDevice && $sameIp ? 98 : 75,
            'action' => 'promo_invalidated',
            'severity' => 'critical',
        ];
    }

    // ✅ Fake Interaction Detection
    private function detectFakeInteraction(
        string $entityType,
        int $entityId,
        array $meta
    ): array {

        if (! isset($meta['job_id'])) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        $job = DB::table('orders')
            ->where('id', $meta['job_id'])
            ->first();

        if (! $job) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        // Check: Job completed too fast (< 5 minutes)
        $completionTime = $job->completed_at
            ? \Carbon\Carbon::parse($job->created_at)
                ->diffInMinutes($job->completed_at)
            : null;

        $tooFast = $completionTime !== null && $completionTime < 5;

        // Check: Same location
        $sameLocation = $meta['provider_lat'] && $meta['customer_lat'] &&
            abs($meta['provider_lat'] - $meta['customer_lat']) < 0.001 &&
            abs($meta['provider_lng'] - $meta['customer_lng']) < 0.001;

        $detected = $tooFast && $sameLocation;
        $confidence = $detected ? 85 : 0;

        return [
            'detected' => $detected,
            'detail' => "Job completed in {$completionTime} minutes. Customer & Provider geo-locations matched perfectly before booking.",
            'confidence' => $confidence,
            'action' => 'reward_clawback',
            'severity' => 'high',
        ];
    }

    // ✅ Promo Stacking Detection
    private function detectPromoStacking(
        int $entityId,
        string $promoCode,
        array $meta
    ): array {

        $appliedCodes = $meta['applied_promo_codes'] ?? [];

        if (empty($appliedCodes)) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        // Check if mutually exclusive
        $exclusiveCodes = ['WELCOME50', 'FREE-DEL', 'NEWUSER'];
        $activeExclusive = array_intersect($appliedCodes, $exclusiveCodes);

        $detected = count($activeExclusive) > 1 ||
            (count($activeExclusive) >= 1 && in_array($promoCode, $exclusiveCodes));

        return [
            'detected' => $detected,
            'detail' => 'Attempted to apply multiple mutually exclusive discount codes via API manipulation.',
            'confidence' => $detected ? 95 : 0,
            'action' => 'promo_dropped',
            'severity' => 'medium',
        ];
    }

    // ✅ Multiple Accounts Per Device
    private function detectMultipleAccountsDevice(
        int $entityId,
        array $meta
    ): array {

        if (! isset($meta['device_hash'])) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        // Count accounts on same device
        $accountsOnDevice = DB::table('devices')
            ->where('fingerprint', $meta['device_hash'])
            ->distinct('user_id')
            ->count('user_id');

        $detected = $accountsOnDevice > 1;
        $confidence = min(100, $accountsOnDevice * 30);

        return [
            'detected' => $detected,
            'detail' => "{$accountsOnDevice} accounts detected on same device.",
            'confidence' => $confidence,
            'action' => 'account_restricted',
            'severity' => 'high',
        ];
    }

    // ✅ New User Old Card
    private function detectNewUserOldCard(
        int $entityId,
        array $meta
    ): array {

        if (! isset($meta['card_fingerprint'])) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'action' => 'none'];
        }

        // Check if card used by another account
        $cardUsedBefore = DB::table('payment_methods')
            ->where('card_fingerprint', $meta['card_fingerprint'])
            ->where('user_id', '!=', $entityId)
            ->exists();

        return [
            'detected' => $cardUsedBefore,
            'detail' => 'New user account with previously used payment card.',
            'confidence' => $cardUsedBefore ? 90 : 0,
            'action' => 'promo_blocked',
            'severity' => 'high',
        ];
    }

    // ✅ Velocity Abuse
    private function detectVelocityAbuse(
        int $entityId,
        string $promoType
    ): array {

        $cacheKey = "promo_velocity:{$entityId}:{$promoType}";
        $count = Cache::get($cacheKey, 0);

        $limits = [
            'referral' => 3,
            'discount' => 5,
            'cashback' => 3,
            'onboarding' => 1,
        ];

        $limit = $limits[$promoType] ?? 5;
        $detected = $count >= $limit;

        return [
            'detected' => $detected,
            'detail' => "Promo velocity exceeded: {$count}/{$limit} attempts.",
            'confidence' => $detected ? 85 : 0,
            'action' => 'promo_blocked',
            'severity' => 'medium',
        ];
    }

    // ═══════════════════════════════════════
    // SYSTEM ACTIONS
    // ═══════════════════════════════════════

    public function applySystemAction(
        PromoAbuseDetection $detection,
        float $promoAmount
    ): void {

        match ($detection->system_action) {
            'promo_invalidated' => $this->invalidatePromo($detection),
            'reward_clawback' => $this->clawbackReward($detection, $promoAmount),
            'promo_dropped' => $this->dropPromo($detection),
            'account_restricted' => $this->restrictAccount($detection),
            'promo_blocked' => $this->blockPromo($detection),
            default => null,
        };

        $detection->update(['status' => 'actioned']);
    }

    private function invalidatePromo(PromoAbuseDetection $detection): void
    {
        // Mark promo as used/invalid for this user
        Cache::put(
            "promo_invalidated:{$detection->entity_id}:{$detection->promo_code}",
            true,
            now()->addDays(30)
        );

        // Restrict account temporarily
        Cache::put(
            "promo_restricted:{$detection->entity_id}",
            true,
            now()->addHours(24)
        );

        Log::warning("❌ Promo invalidated: {$detection->promo_code} for {$detection->entity_ref}");
    }

    private function clawbackReward(
        PromoAbuseDetection $detection,
        float $amount
    ): void {

        // Deduct from wallet
        DB::table('wallet_transactions')->insert([
            'user_id' => $detection->entity_id,
            'type' => 'clawback',
            'amount' => -$amount,
            'reason' => "Reward clawback: {$detection->abuse_pattern}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $detection->update(['clawback_amount' => $amount]);

        Log::warning("💰 Reward clawback: Rs. {$amount} from {$detection->entity_ref}");
    }

    private function dropPromo(PromoAbuseDetection $detection): void
    {
        Cache::put(
            "promo_stacking_blocked:{$detection->entity_id}",
            true,
            now()->addHours(1)
        );

        Log::info("🚫 Promo dropped (stacking): {$detection->entity_ref}");
    }

    private function restrictAccount(PromoAbuseDetection $detection): void
    {
        Cache::put(
            "promo_restricted:{$detection->entity_id}",
            true,
            now()->addDays(7)
        );

        Log::warning("🔒 Account restricted from promos: {$detection->entity_ref}");
    }

    private function blockPromo(PromoAbuseDetection $detection): void
    {
        Cache::put(
            "promo_blocked:{$detection->entity_id}:{$detection->promo_code}",
            true,
            now()->addDays(30)
        );

        Log::info("🚫 Promo blocked: {$detection->promo_code} for {$detection->entity_ref}");
    }

    // ✅ Increment velocity
    public function incrementPromoVelocity(int $userId, string $promoType): void
    {
        $key = "promo_velocity:{$userId}:{$promoType}";
        $count = Cache::increment($key);
        if ($count === 1) {
            Cache::expire($key, 86400);
        }
    }

    // ✅ Dashboard Stats
    public function getDashboardStats(): array
    {
        $fraudSavings = PromoAbuseDetection::where(
            'created_at', '>=', now()->subDays(30)
        )->sum('promo_amount');

        return [
            'fraud_savings_30d' => $fraudSavings,
            'detections_today' => PromoAbuseDetection::today()->count(),
            'self_referrals' => PromoAbuseDetection::today()
                ->where('abuse_pattern', 'self_referral')->count(),
            'promo_stacking' => PromoAbuseDetection::today()
                ->where('abuse_pattern', 'promo_stacking')->count(),
            'fake_interactions' => PromoAbuseDetection::today()
                ->where('abuse_pattern', 'fake_interaction')->count(),
            'clawback_total' => PromoAbuseDetection::today()
                ->sum('clawback_amount'),
            'suspicious_referrals' => ReferralGraph::suspicious()->count(),
        ];
    }
}

<?php

namespace App\Domains\Fraud\Services;

use App\Domains\Fraud\Models\CollusionInvestigation;
use App\Domains\Fraud\Models\CollusionRing;
use App\Domains\Fraud\Models\CollusionRingActor;
use App\Domains\Fraud\Models\InteractionGraph;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CollusionDetectionService
{
    // ═══════════════════════════════════════
    // MAIN SCAN - Called by Middleware
    // ═══════════════════════════════════════

    public function scanInteraction(
        string $actorAType,
        int $actorAId,
        string $actorARef,
        string $actorBType,
        int $actorBId,
        string $actorBRef,
        string $interactionType,
        array $meta = []
    ): ?CollusionRing {

        // ✅ Update interaction graph
        $graph = $this->updateInteractionGraph(
            $actorAType, $actorAId,
            $actorBType, $actorBId,
            $interactionType, $meta
        );

        // ✅ Run detection checks
        $checks = [
            'fake_job_completion_loop' => $this->detectFakeJobLoop($actorAId, $actorBId, $graph),
            'rider_vendor_collusion' => $this->detectRiderVendorCollusion($actorAType, $actorAId, $actorBType, $actorBId, $graph),
            'review_manipulation' => $this->detectReviewManipulation($actorAType, $actorAId, $actorBType, $actorBId, $meta),
            'delivery_fee_farming' => $this->detectDeliveryFeeFarming($actorAType, $actorAId, $actorBType, $actorBId, $graph),
        ];

        foreach ($checks as $pattern => $result) {
            if (! $result['detected']) {
                continue;
            }

            // ✅ Create collusion ring
            $ring = CollusionRing::create([
                'ring_id' => CollusionRing::generateRingId(),
                'ring_type' => $pattern,
                'confidence_score' => $result['confidence'],
                'actors_count' => count($result['actors']),
                'fraud_pattern_detail' => $result['detail'],
                'status' => 'detected',
                'system_enforcement' => $result['enforcement'],
                'meta' => $meta,
            ]);

            // ✅ Add actors
            foreach ($result['actors'] as $actor) {
                CollusionRingActor::create([
                    'ring_id' => $ring->id,
                    'entity_type' => $actor['type'],
                    'entity_id' => $actor['id'],
                    'entity_ref' => $actor['ref'],
                    'role' => $actor['role'],
                    'evidence' => $actor['evidence'] ?? [],
                ]);
            }

            // ✅ Apply enforcement
            $this->applyEnforcement($ring);

            Log::warning("🚨 Collusion ring detected: {$ring->ring_id}", [
                'type' => $pattern,
                'confidence' => $result['confidence'],
                'actors' => count($result['actors']),
            ]);

            return $ring;
        }

        return null;
    }

    // ═══════════════════════════════════════
    // DETECTION METHODS
    // ═══════════════════════════════════════

    // ✅ Fake Job Completion Loop
    private function detectFakeJobLoop(
        int $customerId,
        int $providerId,
        InteractionGraph $graph
    ): array {

        // Check: Same pair repeated jobs
        $jobCount = DB::table('orders')
            ->where('user_id', $customerId)
            ->where('provider_id', $providerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subHours(4))
            ->count();

        // Check: Fast completion (< 5 mins avg)
        $avgTime = DB::table('orders')
            ->where('user_id', $customerId)
            ->where('provider_id', $providerId)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subHours(4))
            ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, updated_at)'));

        // Check: No chat history
        $hasChatHistory = DB::table('messages')
            ->where('sender_id', $customerId)
            ->where('receiver_id', $providerId)
            ->where('created_at', '>=', now()->subHours(4))
            ->exists();

        $detected = $jobCount >= 5 && ($avgTime < 10 || ! $hasChatHistory);
        $confidence = min(100, ($jobCount * 10) + ($hasChatHistory ? 0 : 20));

        return [
            'detected' => $detected,
            'detail' => "{$jobCount} jobs booked and marked complete in 4 hours. No chat/location history.",
            'confidence' => $confidence,
            'enforcement' => 'ranking_suppressed',
            'actors' => [
                [
                    'type' => 'customer',
                    'id' => $customerId,
                    'ref' => 'C-'.$customerId,
                    'role' => 'initiator',
                    'evidence' => ['job_count' => $jobCount, 'avg_time' => $avgTime],
                ],
                [
                    'type' => 'provider',
                    'id' => $providerId,
                    'ref' => 'P-'.$providerId,
                    'role' => 'participant',
                    'evidence' => ['no_chat' => ! $hasChatHistory],
                ],
            ],
        ];
    }

    // ✅ Rider-Vendor Collusion
    private function detectRiderVendorCollusion(
        string $actorAType,
        int $actorAId,
        string $actorBType,
        int $actorBId,
        InteractionGraph $graph
    ): array {

        if (! ($actorAType === 'rider' && $actorBType === 'vendor') &&
            ! ($actorAType === 'vendor' && $actorBType === 'rider')) {
            return ['detected' => false, 'detail' => '', 'confidence' => 0, 'enforcement' => 'none', 'actors' => []];
        }

        $riderId = $actorAType === 'rider' ? $actorAId : $actorBId;
        $vendorId = $actorAType === 'vendor' ? $actorAId : $actorBId;

        // Check: Rider exclusively picks from this vendor
        $totalDeliveries = DB::table('orders')
            ->where('rider_id', $riderId)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $vendorDeliveries = DB::table('orders')
            ->where('rider_id', $riderId)
            ->where('vendor_id', $vendorId)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $exclusivityRatio = $totalDeliveries > 0
            ? ($vendorDeliveries / $totalDeliveries) * 100
            : 0;

        // Check: Shared GPS
        $sharedGps = $graph->shared_gps;

        // Check: Impossible delivery speed
        $impossibleDeliveries = DB::table('orders')
            ->where('rider_id', $riderId)
            ->where('vendor_id', $vendorId)
            ->where(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, updated_at)'), '<', 2)
            ->count();

        $detected = $exclusivityRatio > 80 || ($sharedGps && $impossibleDeliveries > 0);
        $confidence = min(100, (int) $exclusivityRatio + ($sharedGps ? 20 : 0));

        return [
            'detected' => $detected,
            'detail' => 'Rider exclusively picking orders from this Vendor at impossibly high speeds.',
            'confidence' => $confidence,
            'enforcement' => 'investigation_opened',
            'actors' => [
                [
                    'type' => 'rider',
                    'id' => $riderId,
                    'ref' => 'R-'.$riderId,
                    'role' => 'participant',
                    'evidence' => [
                        'exclusivity_ratio' => $exclusivityRatio,
                        'shared_gps' => $sharedGps,
                    ],
                ],
                [
                    'type' => 'vendor',
                    'id' => $vendorId,
                    'ref' => 'V-'.$vendorId,
                    'role' => 'participant',
                    'evidence' => ['impossible_deliveries' => $impossibleDeliveries],
                ],
            ],
        ];
    }

    // ✅ Review Manipulation Ring
    private function detectReviewManipulation(
        string $actorAType,
        int $actorAId,
        string $actorBType,
        int $actorBId,
        array $meta
    ): array {

        $providerId = $actorBType === 'provider' ? $actorBId : $actorAId;

        // Check: Sudden burst of 5-star reviews
        $recentReviews = DB::table('reviews')
            ->where('provider_id', $providerId)
            ->where('rating', 5)
            ->where('created_at', '>=', now()->subHours(24))
            ->count();

        // Check: No payment processing
        $withoutPayment = DB::table('reviews')
            ->where('provider_id', $providerId)
            ->where('rating', 5)
            ->where('created_at', '>=', now()->subHours(24))
            ->whereNotExists(function ($q) {
                $q->from('payments')
                    ->whereColumn('payments.order_id', 'reviews.order_id');
            })
            ->count();

        $detected = $recentReviews >= 5 && $withoutPayment >= 3;
        $confidence = min(100, ($recentReviews * 8) + ($withoutPayment * 10));

        return [
            'detected' => $detected,
            'detail' => 'Sudden burst of 5-star ratings without significant payment processing.',
            'confidence' => $confidence,
            'enforcement' => 'reviews_quarantined',
            'actors' => [
                [
                    'type' => 'provider',
                    'id' => $providerId,
                    'ref' => 'P-'.$providerId,
                    'role' => 'beneficiary',
                    'evidence' => [
                        'fake_reviews' => $recentReviews,
                        'without_payment' => $withoutPayment,
                    ],
                ],
            ],
        ];
    }

    // ✅ Delivery Fee Farming
    private function detectDeliveryFeeFarming(
        string $actorAType,
        int $actorAId,
        string $actorBType,
        int $actorBId,
        InteractionGraph $graph
    ): array {

        $riderId = $actorAType === 'rider' ? $actorAId : $actorBId;
        $vendorId = $actorAType === 'vendor' ? $actorAId : $actorBId;

        // High delivery fee accumulation
        $totalFees = DB::table('orders')
            ->where('rider_id', $riderId)
            ->where('vendor_id', $vendorId)
            ->where('created_at', '>=', now()->subDays(1))
            ->sum('delivery_fee');

        $detected = $totalFees > 50000 && $graph->shared_gps;
        $confidence = $detected ? 88 : 0;

        return [
            'detected' => $detected,
            'detail' => 'Rider farming delivery fees with Vendor through shared GPS coordinates.',
            'confidence' => $confidence,
            'enforcement' => 'payouts_frozen',
            'actors' => [
                [
                    'type' => 'rider',
                    'id' => $riderId,
                    'ref' => 'R-'.$riderId,
                    'role' => 'participant',
                    'evidence' => ['total_fees' => $totalFees],
                ],
                [
                    'type' => 'vendor',
                    'id' => $vendorId,
                    'ref' => 'V-'.$vendorId,
                    'role' => 'participant',
                    'evidence' => ['shared_gps' => $graph->shared_gps],
                ],
            ],
        ];
    }

    // ═══════════════════════════════════════
    // INTERACTION GRAPH UPDATE
    // ═══════════════════════════════════════

    private function updateInteractionGraph(
        string $actorAType,
        int $actorAId,
        string $actorBType,
        int $actorBId,
        string $interactionType,
        array $meta
    ): InteractionGraph {

        $graph = InteractionGraph::updateOrCreate(
            [
                'actor_a_type' => $actorAType,
                'actor_a_id' => $actorAId,
                'actor_b_type' => $actorBType,
                'actor_b_id' => $actorBId,
            ],
            [
                'interaction_type' => $interactionType,
                'shared_gps' => $meta['shared_gps'] ?? false,
                'no_chat_history' => $meta['no_chat'] ?? false,
            ]
        );

        // Increment count
        $graph->increment('interaction_count');

        // Update anomaly score
        $anomalyScore = 0;
        if ($graph->interaction_count > 10) {
            $anomalyScore += 30;
        }
        if ($graph->shared_gps) {
            $anomalyScore += 25;
        }
        if ($graph->no_chat_history) {
            $anomalyScore += 20;
        }

        $graph->update([
            'anomaly_score' => min(100, $anomalyScore),
            'is_suspicious' => $anomalyScore >= 50,
        ]);

        return $graph->fresh();
    }

    // ═══════════════════════════════════════
    // ENFORCEMENT METHODS
    // ═══════════════════════════════════════

    public function applyEnforcement(CollusionRing $ring): void
    {
        match ($ring->system_enforcement) {
            'ranking_suppressed' => $this->suppressRanking($ring),
            'shadow_ban' => $this->applyShadowBan($ring),
            'investigation_opened' => $this->openInvestigation($ring),
            'reviews_quarantined' => $this->quarantineReviews($ring),
            'payouts_frozen' => $this->freezePayouts($ring),
            'bulk_ban' => $this->applyBulkBan($ring),
            default => null,
        };
    }

    private function suppressRanking(CollusionRing $ring): void
    {
        foreach ($ring->actors as $actor) {
            Cache::put(
                "ranking_suppressed:{$actor->entity_type}:{$actor->entity_id}",
                true,
                now()->addDays(30)
            );
            $actor->update(['ranking_suppressed' => true]);
        }
        Log::warning("📉 Ranking suppressed: {$ring->ring_id}");
    }

    private function applyShadowBan(CollusionRing $ring): void
    {
        foreach ($ring->actors as $actor) {
            Cache::put(
                "shadow_banned:{$actor->entity_type}:{$actor->entity_id}",
                true,
                now()->addDays(90)
            );
            $actor->update(['is_shadow_banned' => true]);
        }
        Log::warning("👻 Shadow ban applied: {$ring->ring_id}");
    }

    private function openInvestigation(CollusionRing $ring): void
    {
        CollusionInvestigation::create([
            'ring_id' => $ring->id,
            'opened_by' => 1, // system
            'notes' => "Auto-opened: {$ring->fraud_pattern_detail}",
            'status' => 'open',
        ]);

        // Freeze payouts temporarily
        foreach ($ring->actors as $actor) {
            Cache::put(
                "payout_delay:{$actor->entity_id}",
                now()->addDays(3)->toDateTimeString(),
                now()->addDays(3)
            );
        }
        Log::info("🔍 Investigation opened: {$ring->ring_id}");
    }

    private function quarantineReviews(CollusionRing $ring): void
    {
        foreach ($ring->actors as $actor) {
            // Mark recent reviews as quarantined
            DB::table('reviews')
                ->where('provider_id', $actor->entity_id)
                ->where('rating', 5)
                ->where('created_at', '>=', now()->subHours(24))
                ->update(['is_quarantined' => true]);
        }
        Log::warning("⚠️ Reviews quarantined: {$ring->ring_id}");
    }

    private function freezePayouts(CollusionRing $ring): void
    {
        foreach ($ring->actors as $actor) {
            Cache::put(
                "payout_delay:{$actor->entity_id}",
                now()->addDays(7)->toDateTimeString(),
                now()->addDays(7)
            );
        }
        Log::warning("🔒 Payouts frozen: {$ring->ring_id}");
    }

    private function applyBulkBan(CollusionRing $ring): void
    {
        foreach ($ring->actors as $actor) {
            // Revoke all sessions
            DB::table('user_sessions')
                ->where('user_id', $actor->entity_id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);

            $actor->update(['is_shadow_banned' => true]);
        }
        Log::warning("🚫 Bulk ban applied: {$ring->ring_id}");
    }

    // ✅ Dashboard Stats
    public function getDashboardStats(): array
    {
        return [
            'active_fraud_rings' => CollusionRing::active()->count(),
            'detected_today' => CollusionRing::today()->count(),
            'by_type' => [
                'fake_job_loops' => CollusionRing::where('ring_type', 'fake_job_completion_loop')->count(),
                'rider_vendor' => CollusionRing::where('ring_type', 'rider_vendor_collusion')->count(),
                'review_manipulation' => CollusionRing::where('ring_type', 'review_manipulation')->count(),
                'fee_farming' => CollusionRing::where('ring_type', 'delivery_fee_farming')->count(),
            ],
            'open_investigations' => CollusionInvestigation::where('status', 'open')->count(),
            'shadow_banned_actors' => CollusionRingActor::where('is_shadow_banned', true)->count(),
            'suspicious_pairs' => InteractionGraph::suspicious()->count(),
        ];
    }
}

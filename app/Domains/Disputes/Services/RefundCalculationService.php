<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\RefundPolicy;
use App\Domains\Disputes\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefundCalculationService
{
    // ═══════════════════════════════════════
    // MAIN: Calculate Refund Amount
    // ═══════════════════════════════════════

    public function calculate(
        string $entityType,
        int $entityId,
        float $originalAmount,
        float $requestedAmount,
        string $orderRef,
        array $meta = []
    ): array {

        $policy = RefundPolicy::getActive();

        // ✅ Factor 1: Service Completion %
        $completionPercent = $this->getServiceCompletion(
            $orderRef, $meta
        );

        // ✅ Factor 2: Time Spent
        $timeDeduction = $this->calculateTimeDeduction(
            $orderRef, $completionPercent
        );
        // ✅ Factor 3: Evidence Weight
        $evidenceWeight = $this->calculateEvidenceWeight($meta);

        // ✅ Factor 4: User/Provider History
        $historyFactor = $this->getUserHistoryFactor(
            $entityType, $entityId
        );

        // ✅ Factor 5: Fraud Risk Score
        $fraudScore = $this->getFraudRiskScore($entityType, $entityId);
        // ✅ Check fraud block
        if ($fraudScore >= $policy->fraud_score_block_threshold) {
            return [
                'approved_amount' => 0,
                'status' => 'rejected',
                'rejection_reason' => 'fraud_risk_too_high',
                'fraud_risk_score' => $fraudScore,
                'breakdown' => [],
            ];
        }

        // ✅ Calculate refund amount
        $baseRefund = $requestedAmount;

        // Reduce by completion %
        $completionMatrix = $policy->completion_refund_matrix ?? [];
        $completionRefundPercent = $this->getCompletionRefundPercent(
            $completionPercent,
            $completionMatrix
        );

        $afterCompletion = $baseRefund * ($completionRefundPercent / 100);

        // Apply time deduction
        $afterTime = $afterCompletion * (1 - ($timeDeduction / 100));

        // Apply evidence weight boost
        $afterEvidence = $afterTime * (1 + ($evidenceWeight / 100));

        // Apply history factor
        $finalAmount = $afterEvidence * $historyFactor;

        // Cap at original amount
        $approvedAmount = min($originalAmount, round($finalAmount, 2));

        // ✅ Check finance approval threshold
        $requiresFinance = $approvedAmount >= $policy->finance_approval_threshold;

        $breakdown = [
            'original_amount' => $originalAmount,
            'requested_amount' => $requestedAmount,
            'service_completion_%' => $completionPercent,
            'completion_refund_%' => $completionRefundPercent,
            'after_completion' => round($afterCompletion, 2),
            'time_deduction_%' => $timeDeduction,
            'after_time_deduction' => round($afterTime, 2),
            'evidence_weight_%' => $evidenceWeight,
            'after_evidence_boost' => round($afterEvidence, 2),
            'history_factor' => $historyFactor,
            'fraud_risk_score' => $fraudScore,
            'final_approved_amount' => $approvedAmount,
            'requires_finance_approval' => $requiresFinance,
        ];

        Log::info('💰 Refund calculated', $breakdown);


        return [
            'approved_amount' => $approvedAmount,
            'service_completion_percent' => $completionPercent,
            'fraud_risk_score' => $fraudScore,
            'evidence_weight' => $evidenceWeight,
            'requires_finance_approval' => $requiresFinance,
            'status' => $requiresFinance
                ? 'pending_approval'
                : ($approvedAmount > 0 ? 'approved' : 'rejected'),
            'breakdown' => $breakdown,
        ];
    }

    // ═══════════════════════════════════════
    // CALCULATION FACTORS
    // ═══════════════════════════════════════

    // ✅ Factor 1: Service Completion
    private function getServiceCompletion(
        string $orderRef,
        array $meta
    ): float {

        // From meta if provided
        if (isset($meta['service_completion_percent'])) {
            return (float) $meta['service_completion_percent'];
        }

        // From order status
        $order = DB::table('orders')
            ->where('id', $orderRef)
            ->orWhere('order_number', $orderRef)
            ->first();

        if (! $order) {
            return 0;
        }

        return match ($order->status) {
            'completed' => 100,
            'in_progress' => 50,
            'cancelled' => 0,
            'partial' => $order->completion_percent ?? 30,
            default => 0,
        };
    }

    // ✅ Factor 2: Time Deduction
    private function calculateTimeDeduction(
        string $orderRef,
        float $completionPercent
    ): float {

        // More time spent = less refund
        $order = DB::table('orders')
            ->where('id', $orderRef)
            // ->orWhere('order_number', $orderRef)
            ->first();

        if (! $order) {
            return 0;
        }

        $minutesSpent = $order->started_at
            ? \Carbon\Carbon::parse($order->started_at)
                ->diffInMinutes(now())
            : 0;

        // 0-30 mins: 0% deduction
        // 30-60 mins: 10% deduction
        // 60+ mins: 20% deduction
        return match (true) {
            $minutesSpent > 60 => 20,
            $minutesSpent > 30 => 10,
            default => 0,
        };
    }

    // ✅ Factor 3: Evidence Weight
    private function calculateEvidenceWeight(array $meta): float
    {
        $weight = 0;

        // Photo evidence
        if (! empty($meta['photos'])) {
            $weight += 20;
        }

        // Video evidence
        if (! empty($meta['videos'])) {
            $weight += 30;
        }

        // GPS mismatch
        if ($meta['gps_mismatch'] ?? false) {
            $weight += 25;
        }

        // Chat history
        if (! empty($meta['chat_evidence'])) {
            $weight += 15;
        }

        // Provider admission
        if ($meta['provider_admitted'] ?? false) {
            $weight += 40;
        }

        return min(50, $weight); // max 50% boost
    }

    // ✅ Factor 4: User History Factor
    private function getUserHistoryFactor(
        string $entityType,
        int $entityId
    ): float {

        // Count refunds in last 30 days
        $recentRefunds = RefundRequest::where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // More refunds = lower factor (suspicious)
        return match (true) {
            $recentRefunds >= 5 => 0.5,  // 50% reduction
            $recentRefunds >= 3 => 0.75, // 25% reduction
            $recentRefunds >= 1 => 0.9,  // 10% reduction
            default => 1.0,  // full amount
        };
    }

    // ✅ Factor 5: Fraud Risk Score
    private function getFraudRiskScore(
        string $entityType,
        int $entityId
    ): int {

        $riskScore = DB::table('risk_scores')
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->value('score');

        return $riskScore ?? 0;
    }

    // ✅ Completion refund matrix
    private function getCompletionRefundPercent(
        float $completionPercent,
        array $matrix
    ): float {

        if (! empty($matrix)) {
            foreach ($matrix as $range) {
                if (
                    $completionPercent >= $range['from'] &&
                    $completionPercent <= $range['to']
                ) {
                    return $range['refund_percent'];
                }
            }
        }

        // Default matrix
        return match (true) {
            $completionPercent == 0 => 100, // not started → full refund
            $completionPercent <= 25 => 75,
            $completionPercent <= 50 => 50,
            $completionPercent <= 75 => 25,
            $completionPercent <= 90 => 10,
            default => 0,   // fully done → no refund
        };
    }
}

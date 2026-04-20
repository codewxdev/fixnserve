<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\Appeal;
use App\Domains\Disputes\Models\AppealEvidence;
use App\Domains\Disputes\Models\AppealPolicy;
use App\Domains\Disputes\Models\Complaint;
use App\Domains\Disputes\Models\RefundRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppealService
{
    // ═══════════════════════════════════════
    // VALIDATE: Can User Appeal?
    // ═══════════════════════════════════════

    public function canAppeal(
        string $appellantType,
        int $appellantId,
        string $appealType,
        int $relatedId
    ): array {

        $policy = AppealPolicy::getActive();

        // ✅ Check 1: Appeal window
        $windowCheck = $this->checkAppealWindow(
            $appealType,
            $relatedId,
            $policy
        );

        if (! $windowCheck['valid']) {
            return [
                'can_appeal' => false,
                'reason' => $windowCheck['reason'],
            ];
        }

        // ✅ Check 2: Monthly limit
        $monthlyCount = Appeal::where('appellant_type', $appellantType)
            ->where('appellant_id', $appellantId)
            ->whereMonth('created_at', now()->month)
            ->count();

        if ($monthlyCount >= $policy->max_appeals_per_user) {
            return [
                'can_appeal' => false,
                'reason' => "Monthly appeal limit reached ({$policy->max_appeals_per_user})",
            ];
        }

        // ✅ Check 3: Cooldown period
        $lastAppeal = Appeal::where('appellant_type', $appellantType)
            ->where('appellant_id', $appellantId)
            ->latest()
            ->first();

        if ($lastAppeal) {
            $hoursSinceLast = $lastAppeal->created_at->diffInHours(now());
            if ($hoursSinceLast < $policy->cooldown_hours) {
                $remainingHours = $policy->cooldown_hours - $hoursSinceLast;

                return [
                    'can_appeal' => false,
                    'reason' => "Cooldown active. Try after {$remainingHours} hours",
                ];
            }
        }

        // ✅ Check 4: Already appealed this case
        $alreadyAppealed = Appeal::where('appellant_type', $appellantType)
            ->where('appellant_id', $appellantId)
            ->where(function ($q) use ($appealType, $relatedId) {
                if ($appealType === 'rejected_refund') {
                    $q->where('refund_request_id', $relatedId);
                } else {
                    $q->where('complaint_id', $relatedId);
                }
            })
            ->whereNotIn('status', ['rejected', 'locked'])
            ->exists();

        if ($alreadyAppealed) {
            return [
                'can_appeal' => false,
                'reason' => 'Appeal already exists for this case',
            ];
        }

        // ✅ Check 5: Is case final/locked?
        $isFinal = Appeal::where(function ($q) use ($appealType, $relatedId) {
            if ($appealType === 'rejected_refund') {
                $q->where('refund_request_id', $relatedId);
            } else {
                $q->where('complaint_id', $relatedId);
            }
        })
            ->where('is_final', true)
            ->exists();

        if ($isFinal) {
            return [
                'can_appeal' => false,
                'reason' => 'Case is locked - no further appeals allowed',
            ];
        }

        return [
            'can_appeal' => true,
            'appeals_used' => $monthlyCount,
            'appeals_remaining' => $policy->max_appeals_per_user - $monthlyCount,
            'window_days' => $policy->appeal_window_days,
        ];
    }

    // ✅ Check appeal window
    private function checkAppealWindow(
        string $appealType,
        int $relatedId,
        AppealPolicy $policy
    ): array {

        $relatedAt = null;

        if ($appealType === 'rejected_refund') {
            $refund = RefundRequest::find($relatedId);
            $relatedAt = $refund?->updated_at;

            if ($refund?->status !== 'rejected') {
                return ['valid' => false, 'reason' => 'Refund is not rejected'];
            }
        } else {
            $complaint = Complaint::find($relatedId);
            $relatedAt = $complaint?->updated_at;

            if (! in_array($complaint?->status, ['resolved', 'closed'])) {
                return ['valid' => false, 'reason' => 'Complaint not yet resolved'];
            }
        }

        if (! $relatedAt) {
            return ['valid' => false, 'reason' => 'Related record not found'];
        }

        $daysSince = $relatedAt->diffInDays(now());

        if ($daysSince > $policy->appeal_window_days) {
            return [
                'valid' => false,
                'reason' => "Appeal window expired ({$policy->appeal_window_days} days)",
            ];
        }

        return ['valid' => true];
    }

    // ═══════════════════════════════════════
    // CREATE APPEAL
    // ═══════════════════════════════════════

    public function createAppeal(array $data): Appeal
    {
        $policy = AppealPolicy::getActive();

        $appeal = Appeal::create([
            'appeal_id' => Appeal::generateAppealId(),
            'appeal_type' => $data['appeal_type'],
            'complaint_id' => $data['complaint_id'] ?? null,
            'refund_request_id' => $data['refund_request_id'] ?? null,
            'appellant_type' => $data['appellant_type'],
            'appellant_id' => $data['appellant_id'],
            'appellant_ref' => strtoupper(substr($data['appellant_type'], 0, 1))
                                   .'-'.$data['appellant_id'],
            'appeal_reason' => $data['appeal_reason'],
            'new_evidence' => $data['new_evidence'] ?? null,
            'requested_amount' => $data['requested_amount'] ?? null,
            'submission_deadline' => now()->addDays($policy->appeal_window_days),
            'within_window' => true,
            'status' => 'submitted',
            'final_decision' => 'pending',
        ]);

        // ✅ Save evidence files
        if (! empty($data['evidences'])) {
            foreach ($data['evidences'] as $evidence) {
                AppealEvidence::create([
                    'appeal_id' => $appeal->id,
                    'evidence_type' => $evidence['type'],
                    'file_url' => $evidence['url'] ?? null,
                    'description' => $evidence['description'] ?? null,
                ]);
            }
        }

        Log::info("📝 Appeal submitted: {$appeal->appeal_id}", [
            'type' => $data['appeal_type'],
            'appellant' => $appeal->appellant_ref,
        ]);

        return $appeal;
    }

    // ═══════════════════════════════════════
    // REVIEW: Process Appeal Decision
    // ═══════════════════════════════════════

    public function processDecision(
        Appeal $appeal,
        string $decision,
        float $awardedAmount,
        string $reviewNotes,
        bool $lockCase = false
    ): Appeal {

        $status = match ($decision) {
            'upheld' => 'rejected',
            'overturned' => 'approved',
            'partial' => 'partial_approved',
            default => 'rejected',
        };

        $appeal->update([
            'status' => $status,
            'final_decision' => $decision,
            'awarded_amount' => $awardedAmount,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $reviewNotes,
        ]);

        // ✅ Execute decision
        if (in_array($decision, ['overturned', 'partial'])) {
            $this->executeDecision($appeal, $awardedAmount);
        }

        // ✅ Lock case if final
        if ($lockCase) {
            $this->lockCase($appeal);
        }

        Log::info("⚖️ Appeal decided: {$appeal->appeal_id}", [
            'decision' => $decision,
            'amount' => $awardedAmount,
            'locked' => $lockCase,
        ]);

        return $appeal->fresh();
    }

    // ✅ Execute: Create new refund or update existing
    private function executeDecision(
        Appeal $appeal,
        float $awardedAmount
    ): void {

        DB::transaction(function () use ($appeal, $awardedAmount) {

            if ($appeal->refund_request_id) {
                // ✅ Update existing refund
                $refund = RefundRequest::find($appeal->refund_request_id);
                $refund->update([
                    'status' => 'approved',
                    'approved_amount' => $awardedAmount,
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                    'notes' => "Appeal {$appeal->appeal_id} overturned",
                ]);

                // ✅ Process refund
                app(RefundProcessingService::class)->process($refund);

            } else {
                // ✅ Create new refund request from appeal
                $newRefund = RefundRequest::create([
                    'refund_id' => RefundRequest::generateRefundId(),
                    'complaint_id' => $appeal->complaint_id,
                    'entity_type' => $appeal->appellant_type,
                    'entity_id' => $appeal->appellant_id,
                    'entity_ref' => $appeal->appellant_ref,
                    'refund_type' => 'wallet',
                    'original_amount' => $appeal->requested_amount ?? $awardedAmount,
                    'requested_amount' => $appeal->requested_amount ?? $awardedAmount,
                    'approved_amount' => $awardedAmount,
                    'status' => 'approved',
                    'approved_by' => auth()->id(),
                    'approved_at' => now(),
                    'notes' => "Created from Appeal {$appeal->appeal_id}",
                ]);

                // ✅ Process
                app(RefundProcessingService::class)->process($newRefund);
            }
        });
    }

    // ✅ Lock case - no more appeals
    public function lockCase(Appeal $appeal): void
    {
        $appeal->update([
            'is_final' => true,
            'locked_at' => now(),
            'status' => 'locked',
        ]);

        // Lock complaint too
        if ($appeal->complaint_id) {
            Complaint::find($appeal->complaint_id)?->update([
                'status' => 'closed',
            ]);
        }

        Log::info("🔒 Case locked: {$appeal->appeal_id}");
    }

    // ✅ Dashboard Stats
    public function getDashboardStats(): array
    {
        return [
            'total_submitted' => Appeal::pending()->count(),
            'under_review' => Appeal::underReview()->count(),
            'decided_today' => Appeal::today()
                ->whereNotIn('status', ['submitted', 'under_review'])->count(),
            'by_type' => [
                'rejected_complaint' => Appeal::where('appeal_type', 'rejected_complaint')->count(),
                'partial_refund' => Appeal::where('appeal_type', 'partial_refund')->count(),
                'rejected_refund' => Appeal::where('appeal_type', 'rejected_refund')->count(),
                'account_action' => Appeal::where('appeal_type', 'account_action')->count(),
            ],
            'by_decision' => [
                'upheld' => Appeal::where('final_decision', 'upheld')->count(),
                'overturned' => Appeal::where('final_decision', 'overturned')->count(),
                'partial' => Appeal::where('final_decision', 'partial')->count(),
            ],
            'locked_cases' => Appeal::where('is_final', true)->count(),
        ];
    }
}

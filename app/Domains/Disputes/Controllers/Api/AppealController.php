<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\Appeal;
use App\Domains\Disputes\Models\AppealEvidence;
use App\Domains\Disputes\Models\AppealPolicy;
use App\Domains\Disputes\Services\AppealService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AppealController extends BaseApiController
{
    public function __construct(
        protected AppealService $appealService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->appealService->getDashboardStats(),
            'appeal_dashboard_fetched'
        );
    }

    // ✅ 2. All Appeals (Admin Queue)
    public function index(Request $request)
    {
        $appeals = Appeal::with([
            'complaint:id,case_id,classification',
            'refundRequest:id,refund_id,original_amount',
            'reviewedBy:id,name',
            'evidences',
        ])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->appeal_type, fn ($q) => $q->where('appeal_type', $request->appeal_type))
            ->latest()
            ->paginate(20);

        return $this->success($appeals, 'appeals_fetched');
    }

    // ✅ 3. Check Eligibility
    public function checkEligibility(Request $request)
    {
        $request->validate([
            'appeal_type' => 'required|string',
            'complaint_id' => 'nullable|exists:complaints,id',
            'refund_request_id' => 'nullable|exists:refund_requests,id',
        ]);

        $user = auth()->user();
        $entityType = $this->getEntityType($user);

        $check = $this->appealService->canAppeal(
            appellantType: $entityType,
            appellantId: $user->id,
            appealType: $request->appeal_type,
            relatedId: $request->complaint_id
                        ?? $request->refund_request_id
                        ?? 0
        );

        return $this->success($check, 'eligibility_checked');
    }

    // ✅ 4. Submit Appeal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'appeal_type' => 'required|in:rejected_complaint,partial_refund,account_action,rejected_refund',
            'complaint_id' => 'nullable|exists:complaints,id',
            'refund_request_id' => 'nullable|exists:refund_requests,id',
            'appeal_reason' => 'required|string|min:20|max:2000',
            'requested_amount' => 'nullable|numeric|min:0',

            // Evidence
            'evidences' => 'nullable|array',
            'evidences.*.type' => 'required|in:photo,video,document,chat',
            'evidences.*.url' => 'nullable|string',
            'evidences.*.description' => 'nullable|string|max:500',
        ]);

        // ✅ Merge from middleware
        $validated['appellant_type'] = $request->appellant_type;
        $validated['appellant_id'] = $request->appellant_id;
        // dd($validated);

        $appeal = $this->appealService->createAppeal($validated);

        return $this->success(
            $appeal->load('evidences'),
            'appeal_submitted',
            201
        );
    }

    // ✅ 5. Single Appeal Detail
    public function show(Appeal $appeal)
    {
        return $this->success(
            $appeal->load([
                'complaint',
                'refundRequest',
                'reviewedBy:id,name',
                'evidences',
            ]),
            'appeal_detail_fetched'
        );
    }

    // ✅ 6. Assign to Reviewer
    public function assignReviewer(Request $request, Appeal $appeal)
    {
        $request->validate([
            'reviewer_id' => 'required|exists:users,id',
        ]);

        if ($appeal->status !== 'submitted') {
            return $this->error('appeal_already_under_review', 422);
        }

        $appeal->update([
            'status' => 'under_review',
            'reviewed_by' => $request->reviewer_id,
        ]);

        return $this->success($appeal, 'reviewer_assigned');
    }

    // ✅ 7. Uphold Decision (User loses)
    public function uphold(Request $request, Appeal $appeal)
    {
        $request->validate([
            'review_notes' => 'required|string|min:10|max:1000',
            'lock_case' => 'boolean',
        ]);

        if (! $appeal->canTransitionTo('rejected')) {
            return $this->error('invalid_appeal_status', 422);
        }

        $result = $this->appealService->processDecision(
            appeal: $appeal,
            decision: 'upheld',
            awardedAmount: 0,
            reviewNotes: $request->review_notes,
            lockCase: $request->lock_case ?? false
        );

        return $this->success($result, 'decision_upheld');
    }

    // ✅ 8. Overturn Decision (User wins)
    public function overturn(Request $request, Appeal $appeal)
    {
        $request->validate([
            'awarded_amount' => 'required|numeric|min:0',
            'review_notes' => 'required|string|min:10|max:1000',
            'lock_case' => 'boolean',
        ]);

        if (! $appeal->canTransitionTo('approved')) {
            return $this->error('invalid_appeal_status', 422);
        }

        $result = $this->appealService->processDecision(
            appeal: $appeal,
            decision: 'overturned',
            awardedAmount: $request->awarded_amount,
            reviewNotes: $request->review_notes,
            lockCase: $request->lock_case ?? true
        );

        return $this->success($result, 'decision_overturned_refund_processed');
    }

    // ✅ 9. Partial Decision
    public function partialDecision(Request $request, Appeal $appeal)
    {
        $request->validate([
            'awarded_amount' => 'required|numeric|min:0',
            'review_notes' => 'required|string|min:10|max:1000',
            'lock_case' => 'boolean',
        ]);

        if (! $appeal->canTransitionTo('partial_approved')) {
            return $this->error('invalid_appeal_status', 422);
        }

        $result = $this->appealService->processDecision(
            appeal: $appeal,
            decision: 'partial',
            awardedAmount: $request->awarded_amount,
            reviewNotes: $request->review_notes,
            lockCase: $request->lock_case ?? false
        );

        return $this->success($result, 'partial_decision_processed');
    }

    // ✅ 10. Lock Case
    public function lockCase(Appeal $appeal)
    {
        if ($appeal->is_final) {
            return $this->error('case_already_locked', 422);
        }

        $this->appealService->lockCase($appeal);

        return $this->success($appeal->fresh(), 'case_locked');
    }

    // ✅ 11. Get Policy
    public function getPolicy()
    {
        $policy = AppealPolicy::getActive();

        return $this->success($policy, 'appeal_policy_fetched');
    }

    // ✅ 12. Update Policy
    public function updatePolicy(Request $request, AppealPolicy $policy)
    {
        $data = $request->validate([
            'max_appeals_per_user' => 'sometimes|integer|min:1',
            'appeal_window_days' => 'sometimes|integer|min:1',
            'cooldown_hours' => 'sometimes|integer|min:1',
            'review_sla_hours' => 'sometimes|integer|min:1',
            'require_new_evidence' => 'sometimes|boolean',
        ]);

        $policy->update($data);

        return $this->success($policy, 'appeal_policy_updated');
    }

    // ✅ 13. Add Evidence to Existing Appeal
    public function addEvidence(Request $request, Appeal $appeal)
    {
        $request->validate([
            'evidences' => 'required|array|min:1',
            'evidences.*.type' => 'required|in:photo,video,document,chat',
            'evidences.*.url' => 'nullable|string',
            'evidences.*.description' => 'nullable|string|max:500',
        ]);

        if ($appeal->is_final) {
            return $this->error('case_is_locked', 422);
        }

        $added = [];
        foreach ($request->evidences as $evidence) {
            $added[] = AppealEvidence::create([
                'appeal_id' => $appeal->id,
                'evidence_type' => $evidence['type'],
                'file_url' => $evidence['url'] ?? null,
                'description' => $evidence['description'] ?? null,
            ]);
        }

        return $this->success([
            'appeal' => $appeal->fresh(),
            'added' => $added,
        ], 'evidence_added', 201);
    }

    // ✅ 14. Export
    public function export()
    {
        $appeals = Appeal::with('reviewedBy:id,name')->latest()->get();
        $filename = 'appeals_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($appeals) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Appeal ID', 'Type', 'Appellant',
                'Status', 'Decision', 'Awarded Amount',
                'Reviewed By', 'Created At',
            ]);
            foreach ($appeals as $a) {
                fputcsv($file, [
                    $a->appeal_id, $a->appeal_type,
                    $a->appellant_ref, $a->status,
                    $a->final_decision, $a->awarded_amount,
                    $a->reviewedBy?->name ?? 'N/A',
                    $a->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    private function getEntityType($user): string
    {
        return match (true) {
            $user->hasRole('customer') => 'customer',
            $user->hasRole('rider') => 'rider',
            $user->hasRole('mart_vendor') => 'vendor',
            $user->hasRole('service_provider') => 'provider',
            default => 'user',
        };
    }
}

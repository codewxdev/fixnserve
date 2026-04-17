<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\RefundPolicy;
use App\Domains\Disputes\Models\RefundRequest;
use App\Domains\Disputes\Services\RefundCalculationService;
use App\Domains\Disputes\Services\RefundProcessingService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class RefundEngineController extends BaseApiController
{
    public function __construct(
        protected RefundCalculationService $calculator,
        protected RefundProcessingService $processor
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success([
            'pending' => RefundRequest::pending()->count(),
            'pending_approval' => RefundRequest::pendingApproval()->count(),
            'completed_today' => RefundRequest::where('status', 'completed')
                ->whereDate('processed_at', today())->count(),
            'total_today' => RefundRequest::whereDate('created_at', today())
                ->sum('approved_amount'),
            'by_type' => [
                'wallet' => RefundRequest::where('refund_type', 'wallet')->count(),
                'psp' => RefundRequest::where('refund_type', 'original_payment_method')->count(),
                'store_credit' => RefundRequest::where('refund_type', 'store_credit')->count(),
                'cod' => RefundRequest::where('refund_type', 'cod_adjustment')->count(),
            ],
        ], 'refund_dashboard_fetched');
    }

    // ✅ 2. Get All Refunds
    public function index(Request $request)
    {
        $refunds = RefundRequest::with('complaint', 'approvedBy:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->refund_type, fn ($q) => $q->where('refund_type', $request->refund_type))
            ->latest()
            ->paginate(20);

        return $this->success($refunds, 'refunds_fetched');
    }

    // ✅ 3. Initiate Refund Request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'complaint_id' => 'nullable|exists:complaints,id',
            'entity_type' => 'required|in:customer,rider,vendor,provider',
            'entity_id' => 'required|integer',
            'order_ref' => 'nullable|string',
            'transaction_ref' => 'nullable|string',
            'refund_type' => 'required|in:wallet,original_payment_method,store_credit,cod_adjustment',
            'original_amount' => 'required|numeric|min:0',
            'requested_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',

            // Evidence meta
            'service_completion_percent' => 'nullable|numeric|min:0|max:100',
            'photos' => 'nullable|array',
            'videos' => 'nullable|array',
            'gps_mismatch' => 'nullable|boolean',
            'provider_admitted' => 'nullable|boolean',
        ]);

        // ✅ Calculate refund
        $result = $this->calculator->calculate(
            entityType: $validated['entity_type'],
            entityId: $validated['entity_id'],
            originalAmount: $validated['original_amount'],
            requestedAmount: $validated['requested_amount'],
            orderRef: $validated['order_ref'] ?? '',
            meta: [
                'service_completion_percent' => $validated['service_completion_percent'] ?? null,
                'photos' => $validated['photos'] ?? [],
                'videos' => $validated['videos'] ?? [],
                'gps_mismatch' => $validated['gps_mismatch'] ?? false,
                'provider_admitted' => $validated['provider_admitted'] ?? false,
            ]
        );

        // ✅ Create refund request
        $refund = RefundRequest::create([
            'refund_id' => RefundRequest::generateRefundId(),
            'complaint_id' => $validated['complaint_id'] ?? null,
            'entity_type' => $validated['entity_type'],
            'entity_id' => $validated['entity_id'],
            'entity_ref' => strtoupper(substr($validated['entity_type'], 0, 1))
                                          .'-'.$validated['entity_id'],
            'order_ref' => $validated['order_ref'] ?? null,
            'transaction_ref' => $validated['transaction_ref'] ?? null,
            'refund_type' => $validated['refund_type'],
            'original_amount' => $validated['original_amount'],
            'requested_amount' => $validated['requested_amount'],
            'approved_amount' => $result['approved_amount'],
            'service_completion_percent' => $result['service_completion_percent'],
            'fraud_risk_score' => $result['fraud_risk_score'],
            'evidence_weight' => $result['evidence_weight'],
            'requires_finance_approval' => $result['requires_finance_approval'],
            'status' => $result['status'],
            'rejection_reason' => $result['rejection_reason'] ?? null,
            'calculation_breakdown' => $result['breakdown'],
            'notes' => $validated['notes'] ?? null,
        ]);
        // dd($refund);
        // ✅ Auto process if approved (small amount, no finance needed)
        if ($refund->status === 'approved') {
            $refund = $this->processor->process($refund);
        }

        return $this->success(
            $refund->load('complaint'),
            'refund_request_created',
            201
        );
    }

    // ✅ 4. Approve Refund
    public function approve(Request $request, RefundRequest $refund)
    {
        $request->validate([
            'approved_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        if (! $refund->canTransitionTo('approved')) {
            return $this->error('invalid_refund_status', 422);
        }

        $approvedAmount = $request->approved_amount ?? $refund->approved_amount;

        $refund->update([
            'status' => 'approved',
            'approved_amount' => $approvedAmount,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => $request->notes ?? $refund->notes,
        ]);

        // ✅ Process immediately
        $refund = $this->processor->process($refund);

        return $this->success($refund, 'refund_approved_and_processed');
    }

    // ✅ 5. Reject Refund
    public function reject(Request $request, RefundRequest $refund)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        if (! $refund->canTransitionTo('rejected')) {
            return $this->error('invalid_refund_status', 422);
        }

        $refund->update([
            'status' => 'rejected',
            'rejected_by' => auth()->id(),
            'rejection_reason' => $request->reason,
        ]);

        return $this->success($refund, 'refund_rejected');
    }

    // ✅ 6. Partial Refund
    public function partialRefund(Request $request, RefundRequest $refund)
    {
        $request->validate([
            'partial_amount' => 'required|numeric|min:1|max:'.$refund->requested_amount,
            'reason' => 'required|string|max:500',
        ]);

        if (! $refund->canTransitionTo('approved')) {
            return $this->error('invalid_refund_status', 422);
        }

        $refund->update([
            'status' => 'approved',
            'approved_amount' => $request->partial_amount,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes' => "Partial: {$request->reason}",
        ]);

        $refund = $this->processor->process($refund);

        return $this->success($refund, 'partial_refund_processed');
    }

    // ✅ 7. Escalate to Finance
    public function escalateToFinance(Request $request, RefundRequest $refund)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $refund->update([
            'status' => 'escalated',
            'requires_finance_approval' => true,
            'notes' => "Escalated: {$request->reason}",
        ]);

        return $this->success($refund, 'escalated_to_finance');
    }

    // ✅ 8. Get Calculation Preview
    public function calculatePreview(Request $request)
    {
        $request->validate([
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
            'original_amount' => 'required|numeric',
            'requested_amount' => 'required|numeric',
            'order_ref' => 'nullable|string',
            'service_completion_percent' => 'nullable|numeric',
            'gps_mismatch' => 'nullable|boolean',
            'provider_admitted' => 'nullable|boolean',
        ]);

        $result = $this->calculator->calculate(
            entityType: $request->entity_type,
            entityId: $request->entity_id,
            originalAmount: $request->original_amount,
            requestedAmount: $request->requested_amount,
            orderRef: $request->order_ref ?? '',
            meta: $request->only([
                'service_completion_percent',
                'gps_mismatch',
                'provider_admitted',
            ])
        );

        return $this->success($result, 'refund_preview_calculated');
    }

    // ✅ 9. Get Refund Policy
    public function getPolicy()
    {
        $policy = RefundPolicy::getActive();

        return $this->success($policy, 'refund_policy_fetched');
    }

    // ✅ 10. Update Policy
    public function updatePolicy(Request $request, RefundPolicy $policy)
    {
        $validated = $request->validate([
            'max_auto_approve_amount' => 'sometimes|numeric|min:0',
            'finance_approval_threshold' => 'sometimes|numeric|min:0',
            'max_refunds_per_month' => 'sometimes|integer|min:1',
            'fraud_score_block_threshold' => 'sometimes|numeric|min:0|max:100',
        ]);

        $policy->update($validated);

        return $this->success($policy, 'refund_policy_updated');

    }

    // ✅ 11. Single Detail
    public function show(RefundRequest $refund)
    {
        return $this->success(
            $refund->load(['complaint', 'approvedBy:id,name', 'rejectedBy:id,name']),
            'refund_detail_fetched'
        );
    }
}

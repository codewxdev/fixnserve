<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\CaseEvidence;
use App\Domains\Disputes\Services\EvidenceService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class EvidenceController extends BaseApiController
{
    public function __construct(
        protected EvidenceService $evidenceService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->evidenceService->getDashboardStats(),
            'evidence_dashboard_fetched'
        );
    }

    // ✅ 2. Get Case Evidences
    public function index(Request $request)
    {
        $request->validate([
            'case_type' => 'required|string',
            'case_id' => 'required|integer',
            'evidence_type' => 'nullable|string',
        ]);

        $evidences = CaseEvidence::forCase(
            $request->case_type,
            $request->case_id
        )
            ->with('uploadedBy:id,name')
            ->when($request->evidence_type, fn ($q) => $q->where('evidence_type', $request->evidence_type)
            )
            ->orderBy('event_timestamp')
            ->get();

        return $this->success($evidences, 'evidences_fetched');
    }

    // ✅ 3. Upload Evidence
    public function store(Request $request)
    {
        $data = $request->validate([
            'case_type' => 'required|in:complaint,appeal,refund',
            'case_id' => 'required|integer',
            'case_ref' => 'required|string',
            'evidence_type' => 'required|in:chat_transcript,call_log,delivery_proof,gps_trace,timestamp_log,transaction_log,photo,video,document,otp_verification,system_log',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:20480',
            'content' => 'nullable|array',
            'event_timestamp' => 'nullable|date',
            'linked_order_id' => 'nullable|integer',
            'linked_user_id' => 'nullable|integer',
        ]);

        $evidence = $this->evidenceService->upload(
            $data,
            $request
        );

        return $this->success($evidence, 'evidence_uploaded', 201);
    }

    // ✅ 4. Evidence Detail
    public function show(CaseEvidence $evidence)
    {
        return $this->success(
            $evidence->load([
                'uploadedBy:id,name',
                'lockedBy:id,name',
                'shares.sharedWith:id,name',
            ]),
            'evidence_fetched'
        );
    }

    // ✅ 5. Get Timeline
    public function timeline(Request $request)
    {
        $request->validate([
            'case_type' => 'required|string',
            'case_id' => 'required|integer',
        ]);

        $timeline = $this->evidenceService->buildTimeline(
            $request->case_type,
            $request->case_id
        );

        return $this->success([
            'case_type' => $request->case_type,
            'case_id' => $request->case_id,
            'timeline' => $timeline,
            'total' => count($timeline),
        ], 'timeline_fetched');
    }

    // ✅ 6. Lock Evidence
    public function lock(CaseEvidence $evidence)
    {
        try {
            $locked = $this->evidenceService->lockEvidence($evidence);

            return $this->success($locked, 'evidence_locked');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // ✅ 7. Flag Tampering
    public function flagTampering(Request $request, CaseEvidence $evidence)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $flagged = $this->evidenceService->flagTampering(
            $evidence,
            $request->reason
        );

        return $this->success($flagged, 'tampering_flagged');
    }

    // ✅ 8. Share Evidence
    public function share(Request $request, CaseEvidence $evidence)
    {
        $data = $request->validate([
            'shared_with' => 'required|exists:users,id',
            'department' => 'required|in:legal,finance,ops,compliance,support',
            'reason' => 'nullable|string|max:500',
            'can_download' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $share = $this->evidenceService->shareEvidence(
            $evidence,
            $data
        );

        return $this->success($share, 'evidence_shared', 201);
    }

    // ✅ 9. Verify Integrity
    public function verifyIntegrity(CaseEvidence $evidence)
    {
        $isValid = $evidence->verifyIntegrity();
        $checksum = $evidence->checksum;

        if (! $isValid) {
            $this->evidenceService->flagTampering(
                $evidence,
                'Integrity check failed - checksum mismatch'
            );
        }

        return $this->success([
            'evidence_id' => $evidence->evidence_id,
            'integrity_valid' => $isValid,
            'checksum' => $checksum,
            'is_tampered' => ! $isValid,
            'checked_at' => now()->toDateTimeString(),
        ], 'integrity_verified');
    }
}

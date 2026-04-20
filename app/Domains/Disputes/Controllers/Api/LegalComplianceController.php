<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\ComplianceExport;
use App\Domains\Disputes\Models\LegalCase;
use App\Domains\Disputes\Models\LegalHold;
use App\Domains\Disputes\Services\LegalComplianceService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class LegalComplianceController extends BaseApiController
{
    public function __construct(
        protected LegalComplianceService $legalService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->legalService->getDashboardStats(),
            'legal_dashboard_fetched'
        );
    }

    // ✅ 2. All Cases
    public function index(Request $request)
    {
        $cases = LegalCase::with('handledBy:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->case_type, fn ($q) => $q->where('case_type', $request->case_type))
            ->latest()
            ->paginate(20);

        return $this->success($cases, 'legal_cases_fetched');
    }

    // ✅ 3. Create Legal Case
    public function store(Request $request)
    {
        $validated = $request->validate([
            'related_type' => 'required|in:complaint,appeal,refund',
            'related_id' => 'required|integer',
            'case_ref' => 'required|string',
            'case_type' => 'required|in:regulatory_audit,court_case,internal_review,compliance_check,fraud_investigation',
            'legal_notes' => 'nullable|string|max:2000',
            'regulator_ref' => 'nullable|string|max:100',
        ]);

        $case = $this->legalService->createCase($validated, $request);

        return $this->success($case, 'legal_case_created', 201);
    }

    // ✅ 4. Case Detail
    public function show(LegalCase $legalCase)
    {
        return $this->success(
            $legalCase->load([
                'handledBy:id,name',
                'holds.placedBy:id,name',
                'exports.generatedBy:id,name',
                'auditTrail.actor:id,name',
            ]),
            'legal_case_fetched'
        );
    }

    // ✅ 5. Add Legal Notes
    public function addNotes(Request $request, LegalCase $legalCase)
    {
        $request->validate([
            'legal_notes' => 'required|string|max:5000',
        ]);

        if ($legalCase->is_sealed) {
            return $this->error('case_is_sealed', 422);
        }

        $legalCase->update([
            'legal_notes' => $legalCase->legal_notes
                ."\n\n[".now()->format('Y-m-d H:i').' - '
                .auth()->user()->name."]\n"
                .$request->legal_notes,
        ]);

        $this->legalService->logAudit(
            $legalCase, 'notes_added',
            'Legal notes added',
            $request
        );

        return $this->success($legalCase->fresh(), 'notes_added');
    }

    // ✅ 6. Seal Case
    public function sealCase(Request $request, LegalCase $legalCase)
    {
        try {
            $sealed = $this->legalService->sealCase($legalCase, $request);

            return $this->success($sealed, 'case_sealed');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // ✅ 7. Place Legal Hold
    public function placeLegalHold(Request $request, LegalCase $legalCase)
    {
        $data = $request->validate([
            'hold_type' => 'required|in:data,account,wallet,full',
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
            'reason' => 'required|string|max:500',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $hold = $this->legalService->placeLegalHold(
            $legalCase,
            $data,
            $request
        );

        return $this->success($hold, 'legal_hold_placed', 201);
    }

    // ✅ 8. Lift Legal Hold
    public function liftLegalHold(
        Request $request,
        LegalHold $hold
    ) {
        $lifted = $this->legalService->liftLegalHold($hold, $request);

        return $this->success($lifted, 'legal_hold_lifted');
    }

    // ✅ 9. Generate Bundle
    public function generateBundle(Request $request, LegalCase $legalCase)
    {
        $request->validate([
            'export_type' => 'required|in:case_bundle,evidence_bundle,regulatory_report,audit_trail,full_case_export',
            'format' => 'required|in:json,csv',
            'sections' => 'required|array',
            'sections.*' => 'in:complaint,refunds,appeals,evidence,audit_trail,risk_events',
        ]);

        $export = $this->legalService->generateBundle(
            $legalCase,
            $request->export_type,
            $request->format,
            $request->sections,
            $request
        );

        return $this->success($export, 'bundle_generated', 201);
    }

    // ✅ 10. List Exports
    public function listExports(LegalCase $legalCase)
    {
        $exports = ComplianceExport::where('legal_case_id', $legalCase->id)
            ->with('generatedBy:id,name')
            ->latest()
            ->get();

        return $this->success($exports, 'exports_fetched');
    }

    // ✅ 11. Archive Case
    public function archive(Request $request, LegalCase $legalCase)
    {
        if (! $legalCase->is_sealed) {
            return $this->error('seal_case_before_archiving', 422);
        }

        $legalCase->update(['status' => 'archived']);

        $this->legalService->logAudit(
            $legalCase, 'case_archived',
            'Case moved to archive',
            $request
        );

        return $this->success($legalCase, 'case_archived');
    }

    // ✅ 12. Audit Trail
    public function auditTrail(LegalCase $legalCase)
    {
        $trail = $legalCase->auditTrail()
            ->with('actor:id,name')
            ->latest('created_at')
            ->get();

        return $this->success($trail, 'audit_trail_fetched');
    }
}

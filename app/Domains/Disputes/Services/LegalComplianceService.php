<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\ComplianceExport;
use App\Domains\Disputes\Models\LegalAuditTrail;
use App\Domains\Disputes\Models\LegalCase;
use App\Domains\Disputes\Models\LegalHold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LegalComplianceService
{
    // ═══════════════════════════════════════
    // CREATE LEGAL CASE
    // ═══════════════════════════════════════

    public function createCase(array $data, Request $request): LegalCase
    {
        $case = LegalCase::create([
            'legal_case_id' => LegalCase::generateId(),
            'related_type' => $data['related_type'],
            'related_id' => $data['related_id'],
            'case_ref' => $data['case_ref'],
            'case_type' => $data['case_type'],
            'status' => 'open',
            'handled_by' => auth()->id(),
            'legal_notes' => $data['legal_notes'] ?? null,
            'regulator_ref' => $data['regulator_ref'] ?? null,
        ]);

        $this->logAudit(
            $case, 'case_created',
            "Legal case created: {$case->legal_case_id}",
            $request
        );

        return $case;
    }

    // ═══════════════════════════════════════
    // SEAL CASE
    // Prevents any modifications
    // ═══════════════════════════════════════

    public function sealCase(LegalCase $case, Request $request): LegalCase
    {
        if ($case->is_sealed) {
            throw new \Exception('case_already_sealed');
        }

        $case->update([
            'is_sealed' => true,
            'sealed_at' => now(),
            'status' => 'sealed',
        ]);

        $this->logAudit(
            $case, 'case_sealed',
            'Case sealed by '.auth()->user()->name,
            $request
        );

        Log::warning("🔒 Legal case sealed: {$case->legal_case_id}");

        return $case->fresh();
    }

    // ═══════════════════════════════════════
    // LEGAL HOLD
    // Prevents data deletion
    // ═══════════════════════════════════════

    public function placeLegalHold(
        LegalCase $case,
        array $data,
        Request $request
    ): LegalHold {

        $hold = LegalHold::create([
            'legal_case_id' => $case->id,
            'hold_type' => $data['hold_type'],
            'entity_type' => $data['entity_type'],
            'entity_id' => $data['entity_id'],
            'reason' => $data['reason'],
            'expires_at' => $data['expires_at'] ?? null,
            'placed_by' => auth()->id(),
            'is_active' => true,
        ]);

        $case->update([
            'legal_hold' => true,
            'hold_placed_at' => now(),
            'status' => 'under_legal_hold',
        ]);

        $this->logAudit(
            $case, 'legal_hold_placed',
            "Hold placed: {$data['hold_type']} on {$data['entity_type']} {$data['entity_id']}",
            $request
        );

        return $hold;
    }

    // ✅ Lift Legal Hold
    public function liftLegalHold(
        LegalHold $hold,
        Request $request
    ): LegalHold {

        $hold->update([
            'is_active' => false,
            'lifted_by' => auth()->id(),
            'lifted_at' => now(),
        ]);

        // Check if any holds remain
        $activeHolds = LegalHold::where('legal_case_id', $hold->legal_case_id)
            ->active()
            ->count();

        if ($activeHolds === 0) {
            $hold->legalCase->update(['legal_hold' => false]);
        }

        $this->logAudit(
            $hold->legalCase, 'legal_hold_lifted',
            'Hold lifted by '.auth()->user()->name,
            $request
        );

        return $hold->fresh();
    }

    // ═══════════════════════════════════════
    // GENERATE CASE BUNDLE
    // ═══════════════════════════════════════

    public function generateBundle(
        LegalCase $case,
        string $exportType,
        string $format,
        array $sections,
        Request $request
    ): ComplianceExport {

        // ✅ Collect case data
        $bundleData = $this->collectCaseData($case, $sections);

        // ✅ Generate file
        $filename = $this->generateFileName($case, $exportType, $format);
        $content = $this->formatData($bundleData, $format);
        $checksum = hash('sha256', $content);
        $filePath = "legal_exports/{$filename}";

        // ✅ Save file (simplified - use Storage in production)
        Storage::put($filePath, $content);

        // ✅ Create export record
        $export = ComplianceExport::create([
            'legal_case_id' => $case->id,
            'export_type' => $exportType,
            'export_format' => $format,
            'file_path' => $filePath,
            'file_url' => Storage::url($filePath),
            'file_size' => strlen($content),
            'checksum' => $checksum,
            'generated_by' => auth()->id(),
            'expires_at' => now()->addDays(90),
            'included_sections' => $sections,
        ]);

        $case->update(['status' => 'exported']);

        $this->logAudit(
            $case, 'bundle_generated',
            "Export bundle generated: {$exportType} ({$format})",
            $request
        );

        return $export;
    }

    // ✅ Collect all case data
    private function collectCaseData(LegalCase $case, array $sections): array
    {
        $data = [
            'case_info' => $case->toArray(),
            'generated' => now()->toDateTimeString(),
            'checksum' => null,
        ];

        // ✅ Related case
        if (in_array('complaint', $sections)) {
            $data['complaint'] = DB::table('complaints')
                ->where('id', $case->related_id)
                ->first();
        }

        // ✅ Refund details
        if (in_array('refunds', $sections)) {
            $data['refunds'] = DB::table('refund_requests')
                ->where('complaint_id', $case->related_id)
                ->get();
        }

        // ✅ Appeals
        if (in_array('appeals', $sections)) {
            $data['appeals'] = DB::table('appeals')
                ->where('complaint_id', $case->related_id)
                ->get();
        }

        // ✅ Evidence
        if (in_array('evidence', $sections)) {

            // ✅ 1. case_evidences (Admin added)
            $caseEvidences = DB::table('case_evidences')
                ->where('case_type', $case->related_type)
                ->where('case_id', $case->related_id)
                ->get()
                ->toArray();

            // ✅ 2. appeal_evidences (User added via appeal)
            $appealEvidences = [];
            if ($case->related_type === 'complaint') {

                // Is complaint ke appeals dhundo
                $appeals = DB::table('appeals')
                    ->where('complaint_id', $case->related_id)
                    ->pluck('id');

                if ($appeals->isNotEmpty()) {
                    $appealEvidences = DB::table('appeal_evidences')
                        ->whereIn('appeal_id', $appeals)
                        ->get()
                        ->toArray();
                }
            } $data['evidence'] = [
                'case_evidence_count' => count($caseEvidences),
                'appeal_evidence_count' => count($appealEvidences),
                'case_evidences' => $caseEvidences,
                'appeal_evidences' => $appealEvidences,
            ];
        }

        // ✅ Audit trail
        if (in_array('audit_trail', $sections)) {
            $data['audit_trail'] = $case->auditTrail()
                ->with('actor:id,name')
                ->get();
        }

        // ✅ Risk events
        if (in_array('risk_events', $sections)) {
            $related = DB::table('complaints')->find($case->related_id);
            if ($related) {
                $data['risk_events'] = DB::table('risk_events')
                    ->where('entity_id', $related->reporter_id)
                    ->latest()
                    ->get();
            }
        }

        return $data;
    }

    // ✅ Format data based on type
    private function formatData(array $data, string $format): string
    {
        return match ($format) {
            'json' => json_encode($data, JSON_PRETTY_PRINT),
            'csv' => $this->toCsv($data),
            default => json_encode($data, JSON_PRETTY_PRINT),
        };
    }

    private function toCsv(array $data): string
    {
        $output = fopen('php://temp', 'r+');
        fputcsv($output, ['Section', 'Key', 'Value']);

        foreach ($data as $section => $items) {
            if (is_array($items)) {
                foreach ($items as $key => $val) {
                    fputcsv($output, [
                        $section,
                        $key,
                        is_array($val) ? json_encode($val) : $val,
                    ]);
                }
            }
        }

        rewind($output);

        return stream_get_contents($output);
    }

    private function generateFileName(
        LegalCase $case,
        string $type,
        string $format
    ): string {
        return "{$case->legal_case_id}_{$type}_".
               now()->format('Ymd_His').".{$format}";
    }

    // ✅ Immutable Audit Log
    public function logAudit(
        LegalCase $case,
        string $action,
        string $description,
        Request $request
    ): void {

        LegalAuditTrail::create([
            'legal_case_id' => $case->id,
            'actor_id' => auth()->id() ?? 1,
            'action' => $action,
            'description' => $description,
            'ip_address' => $request->ip(),
            'snapshot' => $case->toArray(),
            'created_at' => now(),
        ]);
    }

    // ✅ Dashboard Stats
    public function getDashboardStats(): array
    {
        return [
            'total_cases' => LegalCase::count(),
            'active' => LegalCase::active()->count(),
            'under_hold' => LegalCase::underHold()->count(),
            'sealed' => LegalCase::sealed()->count(),
            'by_type' => [
                'regulatory_audit' => LegalCase::where('case_type', 'regulatory_audit')->count(),
                'court_case' => LegalCase::where('case_type', 'court_case')->count(),
                'fraud_investigation' => LegalCase::where('case_type', 'fraud_investigation')->count(),
            ],
            'exports_today' => ComplianceExport::whereDate('created_at', today())->count(),
            'active_holds' => LegalHold::active()->count(),
        ];
    }
}

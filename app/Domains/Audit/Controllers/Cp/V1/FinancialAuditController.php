<?php

namespace App\Domains\Audit\Controllers\Cp\V1;

use App\Domains\Audit\Models\CodReconciliation;
use App\Domains\Audit\Models\CommissionLedger;
use App\Domains\Audit\Models\FinancialAuditFlag;
use App\Domains\Audit\Models\FinancialLedger;
use App\Domains\Audit\Models\ReconciliationSnapshot;
use App\Domains\Audit\Services\FinancialAuditService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FinancialAuditController extends BaseApiController
{
    public function __construct(
        protected FinancialAuditService $auditService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->auditService->getDashboardStats(),
            'financial_dashboard_fetched'
        );
    }

    // ✅ 2. Ledger Entries
    public function ledger(Request $request)
    {
        $request->validate([
            'entity_type' => 'nullable|string',
            'entity_id' => 'nullable|integer',
            'entry_type' => 'nullable|string',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        $entries = FinancialLedger::with('auditFlags')
            ->when($request->entity_type && $request->entity_id,
                fn ($q) => $q->byEntity($request->entity_type, $request->entity_id)
            )
            ->when($request->entry_type,
                fn ($q) => $q->where('entry_type', $request->entry_type)
            )
            ->when($request->from && $request->to,
                fn ($q) => $q->byDateRange($request->from, $request->to)
            )
            ->when($request->status,
                fn ($q) => $q->where('status', $request->status)
            )
            ->orderByDesc('posted_at')
            ->paginate(10);

        return $this->success($entries, 'ledger_fetched');
    }

    // ✅ 3. Single Ledger Entry
    public function showLedger(FinancialLedger $ledger)
    {
        return $this->success(
            $ledger->load(['auditFlags', 'commissionLedger']),
            'ledger_entry_fetched'
        );
    }

    // ✅ 4. Verify Ledger Integrity
    public function verifyIntegrity(FinancialLedger $ledger)
    {
        $isValid = $ledger->verifyIntegrity();

        if (! $isValid) {
            FinancialAuditFlag::create([
                'ledger_id' => $ledger->id,
                'flag_type' => 'amount_mismatch',
                'description' => 'Checksum verification failed - possible tampering',
                'severity' => 'critical',
                'status' => 'open',
            ]);
        }

        return $this->success([
            'ledger_id' => $ledger->ledger_id,
            'is_valid' => $isValid,
            'checked_at' => now()->toDateTimeString(),
            'message' => $isValid ? 'Integrity verified' : 'TAMPERED - Flag raised',
        ], 'integrity_verified');
    }

    // ✅ 5. Manual Ledger Entry (Adjustment)
    public function postManualEntry(Request $request)
    {
        $request->validate([
            'entity_type' => 'required|string',
            'entity_id' => 'required|integer',
            'entity_ref' => 'required|string',
            'entry_type' => 'required|in:adjustment,penalty,bonus,tax',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:500',
            'source_module' => 'required|string',
            'source_ref' => 'nullable|string',
        ]);

        $entry = $this->auditService->postEntry(
            entityType: $request->entity_type,
            entityId: $request->entity_id,
            entityRef: $request->entity_ref,
            entryType: $request->entry_type,
            amount: $request->amount,
            sourceModule: $request->source_module,
            sourceRef: $request->source_ref,
            meta: [
                'description' => $request->description,
                'initiated_by' => 'admin',
            ]
        );

        return $this->success($entry, 'manual_entry_posted', 201);
    }

    // ✅ 6. Generate Reconciliation Snapshot
    public function generateSnapshot(Request $request)
    {
        $request->validate([
            'snapshot_type' => 'required|in:daily,weekly,monthly,on_demand',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after_or_equal:period_from',
            'entity_type' => 'nullable|string',
            'entity_id' => 'nullable|integer',
        ]);

        $snapshot = $this->auditService->generateSnapshot(
            type: $request->snapshot_type,
            periodFrom: $request->period_from,
            periodTo: $request->period_to,
            entityType: $request->entity_type,
            entityId: $request->entity_id,
        );

        return $this->success($snapshot, 'snapshot_generated', 201);
    }

    // ✅ 7. All Snapshots
    public function snapshots(Request $request)
    {
        $snapshots = ReconciliationSnapshot::with('generatedBy:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->type, fn ($q) => $q->where('snapshot_type', $request->type))
            ->latest()
            ->paginate(10);

        return $this->success($snapshots, 'snapshots_fetched');
    }

    // ✅ 8. Review Snapshot
    public function reviewSnapshot(Request $request, ReconciliationSnapshot $snapshot)
    {
        $request->validate([
            'status' => 'required|in:matched,investigating,resolved',
            'notes' => 'nullable|string|max:1000',
        ]);

        $snapshot->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return $this->success($snapshot, 'snapshot_reviewed');
    }

    // ✅ 9. COD Reconciliations
    public function codReconciliation(Request $request)
    {
        $cods = CodReconciliation::when(
            $request->status,
            fn ($q) => $q->where('status', $request->status)
        )
            ->when($request->rider_id, fn ($q) => $q->where('rider_id', $request->rider_id))
            ->when($request->overdue, fn ($q) => $q->overdue())
            ->latest()
            ->paginate(10);

        return $this->success($cods, 'cod_reconciliation_fetched');
    }

    // ✅ 10. Mark COD Deposited
    public function markCodDeposited(
        Request $request,
        CodReconciliation $cod
    ) {
        $request->validate([
            'deposited_amount' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        $variance = abs($request->deposited_amount - $cod->expected_amount);

        $cod->update([
            'status' => $variance > 0 ? 'variance_found' : 'deposited',
            'deposited_at' => now(),
            'variance' => $variance,
            'notes' => $request->notes,
        ]);

        // ✅ Post deposit to ledger
        $this->auditService->postEntry(
            entityType: 'rider',
            entityId: $cod->rider_id,
            entityRef: $cod->rider_ref,
            entryType: 'cod_deposit',
            amount: $request->deposited_amount,
            sourceModule: 'cod',
            sourceRef: $cod->cod_ref,
            orderId: $cod->order_id,
            orderRef: $cod->order_ref,
            meta: ['description' => "COD deposited: {$cod->order_ref}"]
        );

        return $this->success($cod, 'cod_deposit_recorded');
    }

    // ✅ 11. Commission Ledger
    public function commissions(Request $request)
    {
        $commissions = CommissionLedger::with('ledgerEntry')
            ->when($request->entity_type && $request->entity_id,
                fn ($q) => $q->where('entity_type', $request->entity_type)
                    ->where('entity_id', $request->entity_id)
            )
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10);

        return $this->success($commissions, 'commissions_fetched');
    }

    // ✅ 12. Audit Flags
    public function auditFlags(Request $request)
    {
        $flags = FinancialAuditFlag::with('ledgerEntry', 'flaggedBy:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->severity, fn ($q) => $q->where('severity', $request->severity))
            ->when(! $request->status, fn ($q) => $q->open())
            ->latest()
            ->paginate(10);

        return $this->success($flags, 'audit_flags_fetched');
    }

    // ✅ 13. Resolve Flag
    public function resolveFlag(
        Request $request,
        FinancialAuditFlag $flag
    ) {
        $request->validate([
            'resolution' => 'required|in:resolved,dismissed',
            'notes' => 'required|string|max:500',
        ]);

        $flag->update([
            'status' => $request->resolution,
            'resolved_by' => auth()->id(),
            'resolved_at' => now(),
        ]);

        return $this->success($flag, 'flag_resolved');
    }

    // ✅ 14. Entity Statement
    public function entityStatement(
        Request $request,
        string $entityType,
        int $entityId
    ) {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        $entries = FinancialLedger::byEntity($entityType, $entityId)
            ->byDateRange($request->from, $request->to)
            ->orderBy('posted_at')
            ->get();

        $summary = [
            'opening_balance' => $entries->first()?->balance_before ?? 0,
            'closing_balance' => $entries->last()?->balance_after ?? 0,
            'total_credits' => $entries->whereIn('entry_type', ['wallet_credit', 'refund', 'bonus'])->sum('amount'),
            'total_debits' => $entries->whereIn('entry_type', ['wallet_debit', 'payout'])->sum('amount'),
            'total_entries' => $entries->count(),
        ];

        return $this->success([
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'period' => ['from' => $request->from, 'to' => $request->to],
            'summary' => $summary,
            'entries' => $entries,
        ], 'statement_fetched');
    }

    // ✅ 15. Export Ledger
    public function exportLedger(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        $entries = FinancialLedger::byDateRange($request->from, $request->to)
            ->get();
        $filename = "ledger_{$request->from}_{$request->to}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($entries) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Ledger ID', 'Entity', 'Type', 'Amount',
                'Balance Before', 'Balance After',
                'Source', 'Reference', 'Status', 'Posted At',
            ]);
            foreach ($entries as $e) {
                fputcsv($file, [
                    $e->ledger_id, $e->entity_ref,
                    $e->entry_type, $e->amount,
                    $e->balance_before, $e->balance_after,
                    $e->source_module, $e->source_ref,
                    $e->status,
                    $e->posted_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

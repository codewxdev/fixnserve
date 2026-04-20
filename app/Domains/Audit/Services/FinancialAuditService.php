<?php

namespace App\Domains\Audit\Services;

use App\Domains\Audit\Models\CodReconciliation;
use App\Domains\Audit\Models\CommissionLedger;
use App\Domains\Audit\Models\FinancialAuditFlag;
use App\Domains\Audit\Models\FinancialLedger;
use App\Domains\Audit\Models\ReconciliationSnapshot;
use Illuminate\Support\Facades\Log;

class FinancialAuditService
{
    // ═══════════════════════════════════════
    // POST LEDGER ENTRY (Core Method)
    // Called by every financial event
    // ═══════════════════════════════════════

    public function postEntry(
        string $entityType,
        int $entityId,
        string $entityRef,
        string $entryType,
        float $amount,
        string $sourceModule,
        ?int $sourceId = null,
        ?string $sourceRef = null,
        ?int $orderId = null,
        ?string $orderRef = null,
        array $meta = []
    ): FinancialLedger {

        // ✅ Get current balance
        $lastEntry = FinancialLedger::byEntity($entityType, $entityId)
            ->latest('posted_at')
            ->first();

        $balanceBefore = $lastEntry?->balance_after ?? 0;

        // ✅ Calculate new balance
        $balanceAfter = match ($entryType) {
            'wallet_credit', 'refund', 'bonus', 'cod_deposit' => $balanceBefore + $amount,
            'wallet_debit', 'payout', 'commission_deduction',
            'penalty', 'tax', 'chargeback' => $balanceBefore - $amount,
            default => $balanceBefore,
        };

        // ✅ Create ledger entry
        $data = [
            'ledger_id' => FinancialLedger::generateId(),
            'transaction_ref' => $meta['transaction_ref'] ?? null,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'entity_ref' => $entityRef,
            'entry_type' => $entryType,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $balanceAfter,
            'currency' => $meta['currency'] ?? 'PKR',
            'source_module' => $sourceModule,
            'source_id' => $sourceId,
            'source_ref' => $sourceRef,
            'order_id' => $orderId,
            'order_ref' => $orderRef,
            'description' => $meta['description'] ?? null,
            'initiated_by' => $meta['initiated_by'] ?? 'system',
            'recorded_by' => auth()->id() ?? null,
            'status' => 'posted',
            'posted_at' => now(),
        ];

        // ✅ Generate checksum for immutability
        $data['checksum'] = FinancialLedger::generateChecksum($data);

        $entry = FinancialLedger::create($data);

        // ✅ Auto-flag suspicious entries
        $this->autoFlagEntry($entry);

        Log::info("📒 Ledger posted: {$entry->ledger_id}", [
            'type' => $entryType,
            'amount' => $amount,
            'entity' => $entityRef,
            'balance' => $balanceAfter,
        ]);

        return $entry;
    }

    // ═══════════════════════════════════════
    // AUTO FLAG SUSPICIOUS ENTRIES
    // ═══════════════════════════════════════

    private function autoFlagEntry(FinancialLedger $entry): void
    {
        $flags = [];

        // ✅ Flag 1: Duplicate transaction
        $duplicate = FinancialLedger::where('entity_id', $entry->entity_id)
            ->where('entry_type', $entry->entry_type)
            ->where('amount', $entry->amount)
            ->where('id', '!=', $entry->id)
            ->where('posted_at', '>=', now()->subMinutes(5))
            ->exists();

        if ($duplicate) {
            $flags[] = [
                'flag_type' => 'duplicate',
                'description' => "Duplicate {$entry->entry_type} of Rs.{$entry->amount} in 5 mins",
                'severity' => 'high',
            ];
        }

        // ✅ Flag 2: Balance mismatch
        if ($entry->balance_after < 0) {
            $flags[] = [
                'flag_type' => 'balance_mismatch',
                'description' => "Negative balance: Rs.{$entry->balance_after}",
                'severity' => 'critical',
            ];
        }

        // ✅ Flag 3: Large amount
        if ($entry->amount > 100000) {
            $flags[] = [
                'flag_type' => 'amount_mismatch',
                'description' => "Unusually large amount: Rs.{$entry->amount}",
                'severity' => 'medium',
            ];
        }

        // ✅ Flag 4: Missing reference
        if (in_array($entry->entry_type, ['refund', 'payout']) &&
            ! $entry->source_ref) {
            $flags[] = [
                'flag_type' => 'missing_reference',
                'description' => "{$entry->entry_type} without source reference",
                'severity' => 'medium',
            ];
        }

        // Create flags
        foreach ($flags as $flag) {
            FinancialAuditFlag::create([
                'ledger_id' => $entry->id,
                'flag_type' => $flag['flag_type'],
                'description' => $flag['description'],
                'severity' => $flag['severity'],
                'status' => 'open',
            ]);

            Log::warning("🚩 Ledger flagged: {$flag['flag_type']}", [
                'ledger_id' => $entry->ledger_id,
                'severity' => $flag['severity'],
            ]);
        }
    }

    // ═══════════════════════════════════════
    // GENERATE RECONCILIATION SNAPSHOT
    // ═══════════════════════════════════════

    public function generateSnapshot(
        string $type,
        string $periodFrom,
        string $periodTo,
        ?string $entityType = null,
        ?int $entityId = null
    ): ReconciliationSnapshot {

        // ✅ Build query
        $query = FinancialLedger::whereBetween('posted_at', [
            $periodFrom.' 00:00:00',
            $periodTo.' 23:59:59',
        ]);

        if ($entityType && $entityId) {
            $query->byEntity($entityType, $entityId);
        }

        $entries = $query->get();

        // ✅ Calculate totals
        $totals = [
            'credits' => $entries->whereIn('entry_type', ['wallet_credit', 'refund', 'bonus'])->sum('amount'),
            'debits' => $entries->whereIn('entry_type', ['wallet_debit', 'penalty'])->sum('amount'),
            'payouts' => $entries->where('entry_type', 'payout')->sum('amount'),
            'refunds' => $entries->where('entry_type', 'refund')->sum('amount'),
            'chargebacks' => $entries->where('entry_type', 'chargeback')->sum('amount'),
            'commission' => $entries->whereIn('entry_type', ['commission', 'commission_deduction'])->sum('amount'),
            'cod' => $entries->whereIn('entry_type', ['cod_collection', 'cod_deposit'])->sum('amount'),
        ];

        $netBalance = $totals['credits'] - $totals['debits'] - $totals['payouts'];
        $lastEntry = $entries->last();
        $expectedBalance = $lastEntry?->balance_after ?? 0;
        $variance = abs($netBalance - $expectedBalance);

        // ✅ Breakdown by type
        $breakdown = $entries->groupBy('entry_type')
            ->map(fn ($group) => [
                'count' => $group->count(),
                'total' => $group->sum('amount'),
            ])
            ->toArray();

        $snapshot = ReconciliationSnapshot::create([
            'snapshot_id' => ReconciliationSnapshot::generateId(),
            'snapshot_type' => $type,
            'period_from' => $periodFrom,
            'period_to' => $periodTo,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'total_credits' => $totals['credits'],
            'total_debits' => $totals['debits'],
            'total_payouts' => $totals['payouts'],
            'total_refunds' => $totals['refunds'],
            'total_chargebacks' => $totals['chargebacks'],
            'total_commission' => $totals['commission'],
            'total_cod' => $totals['cod'],
            'net_balance' => $netBalance,
            'expected_balance' => $expectedBalance,
            'variance' => $variance,
            'status' => $variance > 0 ? 'variance_found' : 'matched',
            'total_transactions' => $entries->count(),
            'unreconciled_count' => $entries->where('is_reconciled', false)->count(),
            'generated_by' => auth()->id(),
            'breakdown' => $breakdown,
            'checksum' => hash('sha256', json_encode($totals)),
        ]);

        Log::info("📊 Snapshot generated: {$snapshot->snapshot_id}", [
            'variance' => $variance,
            'status' => $snapshot->status,
        ]);

        return $snapshot;
    }

    // ═══════════════════════════════════════
    // COD RECONCILIATION
    // ═══════════════════════════════════════

    public function recordCodCollection(
        int $riderId,
        string $riderRef,
        int $orderId,
        string $orderRef,
        float $collectedAmount,
        float $expectedAmount
    ): CodReconciliation {

        $cod = CodReconciliation::create([
            'cod_ref' => 'COD-'.now()->format('Ymd').'-'.$orderId,
            'rider_id' => $riderId,
            'rider_ref' => $riderRef,
            'order_id' => $orderId,
            'order_ref' => $orderRef,
            'collected_amount' => $collectedAmount,
            'expected_amount' => $expectedAmount,
            'variance' => abs($collectedAmount - $expectedAmount),
            'status' => 'pending',
            'collected_at' => now(),
            'due_at' => now()->addHours(48),
        ]);

        // ✅ Post to ledger
        $this->postEntry(
            entityType: 'rider',
            entityId: $riderId,
            entityRef: $riderRef,
            entryType: 'cod_collection',
            amount: $collectedAmount,
            sourceModule: 'order',
            sourceId: $orderId,
            sourceRef: $orderRef,
            orderId: $orderId,
            orderRef: $orderRef,
            meta: ['description' => "COD collected: {$orderRef}"]
        );

        return $cod;
    }

    // ✅ Calculate Commission
    public function calculateCommission(
        int $orderId,
        string $orderRef,
        string $entityType,
        int $entityId,
        string $entityRef,
        float $orderAmount,
        float $commissionRate
    ): CommissionLedger {

        $commissionAmount = ($orderAmount * $commissionRate) / 100;
        $taxAmount = $commissionAmount * 0.13; // 13% tax
        $netPayout = $orderAmount - $commissionAmount - $taxAmount;

        // ✅ Post commission to ledger
        $ledgerEntry = $this->postEntry(
            entityType: $entityType,
            entityId: $entityId,
            entityRef: $entityRef,
            entryType: 'commission_deduction',
            amount: $commissionAmount + $taxAmount,
            sourceModule: 'order',
            sourceId: $orderId,
            sourceRef: $orderRef,
            orderId: $orderId,
            orderRef: $orderRef,
            meta: [
                'description' => "Commission {$commissionRate}% on {$orderRef}",
                'commission_rate' => $commissionRate,
            ]
        );

        $commission = CommissionLedger::create([
            'commission_ref' => CommissionLedger::generateRef(),
            'order_id' => $orderId,
            'order_ref' => $orderRef,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'entity_ref' => $entityRef,
            'order_amount' => $orderAmount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'tax_amount' => $taxAmount,
            'net_payout' => $netPayout,
            'status' => 'calculated',
            'ledger_id' => $ledgerEntry->id,
        ]);

        return $commission;
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        $today = today()->format('Y-m-d');
        $thisMonth = now()->startOfMonth()->format('Y-m-d');

        return [
            'today' => [
                'total_credits' => FinancialLedger::whereDate('posted_at', $today)
                    ->whereIn('entry_type', ['wallet_credit', 'refund', 'bonus'])
                    ->sum('amount'),
                'total_debits' => FinancialLedger::whereDate('posted_at', $today)
                    ->whereIn('entry_type', ['wallet_debit', 'payout'])
                    ->sum('amount'),
                'total_transactions' => FinancialLedger::whereDate('posted_at', $today)
                    ->count(),
                'flagged' => FinancialAuditFlag::open()
                    ->whereDate('created_at', $today)->count(),
            ],
            'cod' => [
                'pending' => CodReconciliation::pending()->count(),
                'overdue' => CodReconciliation::overdue()->count(),
                'variance_found' => CodReconciliation::where('status', 'variance_found')->count(),
            ],
            'reconciliation' => [
                'pending_snapshots' => ReconciliationSnapshot::pending()->count(),
                'variance_found' => ReconciliationSnapshot::variance()->count(),
                'last_snapshot' => ReconciliationSnapshot::latest()->first()?->created_at?->diffForHumans(),
            ],
            'audit_flags' => [
                'open' => FinancialAuditFlag::open()->count(),
                'critical' => FinancialAuditFlag::open()->where('severity', 'critical')->count(),
            ],
        ];
    }
}

<?php

namespace App\Domains\Audit\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialLedger extends Model
{
    public array $translatable = ['description'];

    protected $fillable = [
        'ledger_id', 'transaction_ref',
        'entity_type', 'entity_id', 'entity_ref',
        'entry_type', 'amount',
        'balance_before', 'balance_after', 'currency',
        'source_module', 'source_id', 'source_ref',
        'order_id', 'order_ref',
        'commission_rate', 'commission_amount', 'tax_amount',
        'status', 'description', 'initiated_by',
        'recorded_by', 'checksum', 'is_reconciled',
        'meta', 'posted_at', 'translations',
    ];

    protected $casts = [
        'meta' => 'array',
        'is_reconciled' => 'boolean',
        'posted_at' => 'datetime',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function auditFlags()
    {
        return $this->hasMany(FinancialAuditFlag::class, 'ledger_id');
    }

    public function commissionLedger()
    {
        return $this->hasOne(CommissionLedger::class, 'ledger_id');
    }

    // ✅ Generate Ledger ID
    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'LDG-'.$year.'-'.str_pad($count, 6, '0', STR_PAD_LEFT);
    }

    // ✅ Generate immutable checksum
    public static function generateChecksum(array $data): string
    {
        return hash('sha256', json_encode([
            $data['entity_id'],
            $data['entry_type'],
            $data['amount'],
            $data['balance_before'],
            $data['balance_after'],
            $data['posted_at'],
        ]));
    }

    // ✅ Verify integrity
    public function verifyIntegrity(): bool
    {
        if (! $this->checksum) {
            return true;
        }

        $expected = self::generateChecksum([
            'entity_id' => $this->entity_id,
            'entry_type' => $this->entry_type,
            'amount' => $this->amount,
            'balance_before' => $this->balance_before,
            'balance_after' => $this->balance_after,
            'posted_at' => $this->posted_at,
        ]);

        return $expected === $this->checksum;
    }

    // ✅ Scopes
    public function scopeByEntity($query, string $type, int $id)
    {
        return $query->where('entity_type', $type)
            ->where('entity_id', $id);
    }

    public function scopeByDateRange($query, string $from, string $to)
    {
        return $query->whereBetween('posted_at', [$from, $to]);
    }

    public function scopeFlagged($query)
    {
        return $query->whereHas('auditFlags', fn ($q) => $q->where('status', 'open')
        );
    }
}

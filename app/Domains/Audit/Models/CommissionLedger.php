<?php

namespace App\Domains\Audit\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CommissionLedger extends Model
{
    use HasTranslations;

    public array $translatable = ['description', 'entity_ref', 'order_ref'];

    protected $fillable = [
        'commission_ref', 'order_id', 'order_ref',
        'entity_type', 'entity_id', 'entity_ref',
        'order_amount', 'commission_rate',
        'commission_amount', 'tax_amount', 'net_payout',
        'status', 'ledger_id', 'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    public function ledgerEntry()
    {
        return $this->belongsTo(FinancialLedger::class, 'ledger_id');
    }

    public static function generateRef(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'COM-'.$year.'-'.str_pad($count, 5, '0', STR_PAD_LEFT);
    }
}

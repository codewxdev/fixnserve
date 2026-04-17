<?php

namespace App\Domains\Audit\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ReconciliationSnapshot extends Model
{
    use HasTranslations;

    public array $translatable = ['notes'];

    protected $fillable = [
        'snapshot_id', 'snapshot_type',
        'period_from', 'period_to',
        'entity_type', 'entity_id',
        'total_credits', 'total_debits',
        'total_payouts', 'total_refunds',
        'total_chargebacks', 'total_commission',
        'total_cod', 'net_balance',
        'expected_balance', 'variance',
        'status', 'total_transactions',
        'unreconciled_count', 'notes',
        'generated_by', 'reviewed_by',
        'reviewed_at', 'checksum',
        'breakdown', 'translations',
    ];

    protected $casts = [
        'period_from' => 'date',
        'period_to' => 'date',
        'reviewed_at' => 'datetime',
        'breakdown' => 'array',
        'translations' => 'array',
    ];

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'SNAP-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVariance($query)
    {
        return $query->where('status', 'variance_found');
    }
}

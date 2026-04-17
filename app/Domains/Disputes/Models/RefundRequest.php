<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasTranslations;

    public array $translatable = ['notes', 'entity_ref', 'order_ref', 'transaction_ref', 'refund_type', 'rejection_reason', 'calculation_breakdown', 'psp_status', 'entity_type'];

    protected $fillable = [
        'refund_id', 'complaint_id',
        'entity_type', 'entity_id', 'entity_ref',
        'order_ref', 'transaction_ref',
        'refund_type', 'original_amount',
        'requested_amount', 'approved_amount',
        'service_completion_percent',
        'calculation_breakdown', 'fraud_risk_score',
        'evidence_weight', 'status',
        'requires_finance_approval',
        'approved_by', 'rejected_by',
        'rejection_reason', 'approved_at',
        'psp_transaction_id', 'psp_status',
        'processed_at', 'notes', 'translations',
    ];

    protected $casts = [
        'calculation_breakdown' => 'array',
        'requires_finance_approval' => 'boolean',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    // ✅ Generate Refund ID
    public static function generateRefundId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'REF-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // ✅ State Machine
    const TRANSITIONS = [
        'pending' => ['calculating'],
        'calculating' => ['pending_approval', 'approved', 'rejected'],
        'pending_approval' => ['approved', 'rejected', 'escalated'],
        'approved' => ['processing'],
        'processing' => ['completed', 'failed'],
        'escalated' => ['approved', 'rejected'],
        'rejected' => [],
        'completed' => [],
        'failed' => ['processing'], // retry
    ];

    public function canTransitionTo(string $status): bool
    {
        return in_array(
            $status,
            self::TRANSITIONS[$this->status] ?? []
        );
    }

    // ✅ Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending_approval');
    }
}

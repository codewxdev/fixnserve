<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    use HasTranslations;

    protected $fillable = [
        'appeal_id', 'appeal_type',
        'complaint_id', 'refund_request_id',
        'appellant_type', 'appellant_id', 'appellant_ref',
        'appeal_reason', 'new_evidence',
        'requested_amount', 'submission_deadline',
        'within_window', 'reviewed_by', 'reviewed_at',
        'review_notes', 'status', 'final_decision',
        'awarded_amount', 'is_final', 'locked_at',
        'translations',
    ];

    protected $casts = [
        'new_evidence' => 'array',
        'submission_deadline' => 'datetime',
        'reviewed_at' => 'datetime',
        'locked_at' => 'datetime',
        'within_window' => 'boolean',
        'is_final' => 'boolean',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function refundRequest()
    {
        return $this->belongsTo(RefundRequest::class);
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function evidences()
    {
        return $this->hasMany(AppealEvidence::class);
    }

    // ✅ Generate Appeal ID
    public static function generateAppealId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'APP-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // ✅ State Machine
    const TRANSITIONS = [
        'submitted' => ['under_review', 'rejected'],
        'under_review' => ['approved', 'rejected', 'partial_approved'],
        'approved' => ['locked', 'rejected'],
        'rejected' => ['locked', 'approved'],
        'partial_approved' => ['locked'],
        'locked' => [],
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
        return $query->where('status', 'submitted');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('status', 'under_review');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}

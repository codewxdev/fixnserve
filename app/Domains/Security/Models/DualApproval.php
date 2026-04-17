<?php

namespace App\Domains\Security\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class DualApproval extends Model
{
    use HasTranslations;

    public array $translatable = ['justification', 'action_type', 'status'];

    protected $table = 'dual_approval_requests';

    protected $fillable = [
        'action_type',
        'payload',
        'requested_by',
        'status',
        'approved_by_level_1',
        'approved_at_level_1',
        'approved_by_level_2',
        'approved_at_level_2',
        'justification',
        'expires_at',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'payload' => 'array',
        'expires_at' => 'datetime',
    ];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approved_by_level_1');
    }

    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approved_by_level_2');
    }

    const TRANSITIONS = [
        'pending' => ['approved_level_1', 'rejected', 'expired'],
        'approved_level_1' => ['approved', 'rejected', 'expired'],
        'approved' => ['executed', 'expired'],
        'executed' => [],
        'rejected' => [],
        'expired' => [],
    ];

    public function auditLogs()
    {
        return $this->hasMany(
            ApprovalAuditLog::class,
            'dual_approval_id'
        );
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array(
            $status,
            self::TRANSITIONS[$this->status] ?? []
        );
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isFullyApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function getCurrentApprovalLevel(): int
    {
        if (! $this->approved_by_level_1) {
            return 1;
        }
        if (! $this->approved_by_level_2) {
            return 2;
        }

        return 0;
    }

    // ✅ Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeNeedsDualApproval($query)
    {
        return $query->whereIn('action_type', [
            'wallet_unfreeze',
            'suspension_rollback',
            'account_unfreeze',
            'risk_score_override',
        ]);
    }
}

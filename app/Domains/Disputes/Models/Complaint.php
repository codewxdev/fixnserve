<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasTranslations;

    public array $translatable = ['dispute_reason', 'initial_notes', 'classification_meta', 'source', 'reporter_type', 'reporter_ref', 'status'];

    protected $fillable = [
        'case_id', 'source', 'reporter_type',
        'reporter_id', 'reporter_ref',
        'related_entity_id', 'related_entity_type',
        'classification', 'is_auto_classified',
        'dispute_reason', 'initial_notes',
        'severity', 'sla_hours', 'sla_deadline',
        'sla_breached', 'status',
        'assigned_to', 'assigned_at', 'created_by',
        'classification_meta', 'translations',
    ];

    protected $casts = [
        'is_auto_classified' => 'boolean',
        'sla_breached' => 'boolean',
        'sla_deadline' => 'datetime',
        'assigned_at' => 'datetime',
        'classification_meta' => 'array',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Generate Case ID
    public static function generateCaseId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'CASE-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // ✅ SLA remaining time
    public function getSlaRemainingAttribute(): ?string
    {
        if (! $this->sla_deadline) {
            return null;
        }

        if ($this->sla_deadline->isPast()) {
            return 'BREACHED';
        }

        $diff = now()->diff($this->sla_deadline);
        $hours = $diff->h + ($diff->days * 24);
        $minutes = $diff->i;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m left";
        }

        return "{$minutes}m left";
    }

    // ✅ Scopes
    public function scopeUnassigned($query)
    {
        return $query->where('status', 'unassigned');
    }

    public function scopeSlaBreachingSoon($query)
    {
        return $query->where('sla_deadline', '<=', now()->addHours(1))
            ->where('sla_breached', false)
            ->whereNotIn('status', ['resolved', 'closed']);
    }

    public function scopePriorityQueue($query)
    {
        return $query->orderByRaw("
            CASE severity
                WHEN 'critical' THEN 1
                WHEN 'high'     THEN 2
                WHEN 'medium'   THEN 3
                WHEN 'low'      THEN 4
            END
        ")->orderBy('sla_deadline');
    }
}

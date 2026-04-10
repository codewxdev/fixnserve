<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SlaTracking extends Model
{
    use HasTranslations;

    protected $fillable = [
        'trackable_type', 'trackable_id', 'case_ref',
        'sla_level', 'started_at',
        'first_response_due', 'resolution_due',
        'first_response_at', 'resolved_at',
        'first_response_breached', 'resolution_breached',
        'breach_count', 'escalation_level',
        'current_assignee_role', 'current_assignee_id',
        'escalation_history', 'translations',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'first_response_due' => 'datetime',
        'resolution_due' => 'datetime',
        'first_response_at' => 'datetime',
        'resolved_at' => 'datetime',
        'first_response_breached' => 'boolean',
        'resolution_breached' => 'boolean',
        'escalation_history' => 'array',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function currentAssignee()
    {
        return $this->belongsTo(User::class, 'current_assignee_id');
    }

    public function escalationEvents()
    {
        return $this->hasMany(EscalationEvent::class);
    }

    // ✅ Time remaining
    public function getTimeRemainingAttribute(): string
    {
        if (! $this->resolution_due) {
            return 'N/A';
        }
        if ($this->resolution_due->isPast()) {
            return 'BREACHED';
        }

        $diff = now()->diff($this->resolution_due);
        $hours = $diff->h + ($diff->days * 24);
        $minutes = $diff->i;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    // ✅ Is approaching breach
    public function isApproachingBreach(): bool
    {
        if (! $this->resolution_due) {
            return false;
        }

        return $this->resolution_due->diffInHours(now()) <= 1
            && ! $this->resolution_due->isPast();
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->whereNull('resolved_at');
    }

    public function scopeBreached($query)
    {
        return $query->where('resolution_breached', true)
            ->whereNull('resolved_at');
    }

    public function scopeApproaching($query)
    {
        return $query->where('resolution_due', '<=', now()->addHour())
            ->where('resolution_due', '>', now())
            ->whereNull('resolved_at');
    }
}

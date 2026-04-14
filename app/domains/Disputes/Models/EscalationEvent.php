<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EscalationEvent extends Model
{
    use HasTranslations;

    protected $fillable = [
        'sla_tracking_id', 'from_role', 'to_role',
        'from_assignee', 'to_assignee',
        'trigger_type', 'notes',
        'triggered_by', 'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    public function slaTracking()
    {
        return $this->belongsTo(SlaTracking::class);
    }

    public function fromAssignee()
    {
        return $this->belongsTo(User::class, 'from_assignee');
    }

    public function toAssignee()
    {
        return $this->belongsTo(User::class, 'to_assignee');
    }
}

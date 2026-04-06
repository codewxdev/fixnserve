<?php

namespace App\Domains\Fraud\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CollusionInvestigation extends Model
{
    use HasTranslations;

    protected $fillable = [
        'ring_id', 'opened_by', 'notes',
        'status', 'assigned_to', 'closed_at',
        'translations',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'translations' => 'array',
    ];

    public function ring()
    {
        return $this->belongsTo(CollusionRing::class, 'ring_id');
    }

    public function openedBy()
    {
        return $this->belongsTo(User::class, 'opened_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

<?php

namespace App\Domains\Fraud\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class RiskEnforcement extends Model
{
    use HasTranslations;

    protected $fillable = [
        'entity_type', 'entity_id', 'action',
        'trigger', 'risk_score', 'reason',
        'enforced_by', 'expires_at', 'is_active', 'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function enforcedBy()
    {
        return $this->belongsTo(User::class, 'enforced_by');
    }
}

<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EnforcementAction extends Model
{
    use HasTranslations;

    protected $fillable = [
        'abuse_detection_id', 'entity_type', 'entity_id',
        'action_type', 'reason', 'expires_at',
        'is_active', 'enforced_by', 'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function abuseDetection()
    {
        return $this->belongsTo(AbuseDetection::class, 'abuse_detection_id');
    }

    public function enforcedBy()
    {
        return $this->belongsTo(User::class, 'enforced_by');
    }

    // ✅ Check if active
    public function isCurrentlyActive(): bool
    {
        if (! $this->is_active) {
            return false;
        }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }
}

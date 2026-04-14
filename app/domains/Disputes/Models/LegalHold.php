<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class LegalHold extends Model
{
    use HasTranslations;

    protected $fillable = [
        'legal_case_id', 'hold_type',
        'entity_type', 'entity_id', 'reason',
        'expires_at', 'is_active',
        'placed_by', 'lifted_by', 'lifted_at',
        'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'lifted_at' => 'datetime',
        'is_active' => 'boolean',
        'translations' => 'array',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function placedBy()
    {
        return $this->belongsTo(User::class, 'placed_by');
    }

    public function liftedBy()
    {
        return $this->belongsTo(User::class, 'lifted_by');
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

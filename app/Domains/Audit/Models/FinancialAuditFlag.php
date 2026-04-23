<?php

namespace App\Domains\Audit\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class FinancialAuditFlag extends Model
{
    use HasTranslations;

    public array $translatable = ['description', 'flag_type', 'severity'];

    protected $fillable = [
        'ledger_id', 'flag_type', 'description',
        'severity', 'status',
        'flagged_by', 'resolved_by', 'resolved_at',
        'translations',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
        'translations' => 'array',
    ];

    public function ledgerEntry()
    {
        return $this->belongsTo(FinancialLedger::class, 'ledger_id');
    }

    public function flaggedBy()
    {
        return $this->belongsTo(User::class, 'flagged_by');
    }

    public function resolvedBy()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }
}

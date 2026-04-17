<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class LegalCase extends Model
{
    use HasTranslations;

    public array $translatable = ['case_ref', 'case_type', 'status', 'legal_notes', 'regulator_ref', 'meta'];

    protected $fillable = [
        'legal_case_id', 'related_type', 'related_id',
        'case_ref', 'case_type', 'status',
        'is_sealed', 'legal_hold',
        'sealed_at', 'hold_placed_at', 'hold_expires_at',
        'handled_by', 'legal_notes', 'regulator_ref',
        'meta', 'translations',
    ];

    protected $casts = [
        'is_sealed' => 'boolean',
        'legal_hold' => 'boolean',
        'sealed_at' => 'datetime',
        'hold_placed_at' => 'datetime',
        'hold_expires_at' => 'datetime',
        'meta' => 'array',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function holds()
    {
        return $this->hasMany(LegalHold::class);
    }

    public function exports()
    {
        return $this->hasMany(ComplianceExport::class);
    }

    public function auditTrail()
    {
        return $this->hasMany(LegalAuditTrail::class);
    }

    // ✅ Generate Legal Case ID
    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'LC-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // ✅ Can be modified?
    public function isEditable(): bool
    {
        return ! $this->is_sealed && ! $this->legal_hold;
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['archived', 'closed']);
    }

    public function scopeUnderHold($query)
    {
        return $query->where('legal_hold', true);
    }

    public function scopeSealed($query)
    {
        return $query->where('is_sealed', true);
    }
}

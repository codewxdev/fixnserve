<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class CaseEvidence extends Model
{
    use HasTranslations;

    protected $table = 'case_evidences';

    protected $fillable = [
        'evidence_id', 'case_type', 'case_id', 'case_ref',
        'evidence_type', 'title', 'description',
        'file_path', 'file_url', 'content', 'checksum',
        'event_timestamp',
        'linked_order_id', 'linked_user_id', 'linked_wallet_tx_id',
        'is_locked', 'is_tampered', 'is_shared',
        'locked_at', 'uploaded_by', 'locked_by',
        'meta', 'translations',
    ];

    protected $casts = [
        'content' => 'array',
        'meta' => 'array',
        'is_locked' => 'boolean',
        'is_tampered' => 'boolean',
        'is_shared' => 'boolean',
        'event_timestamp' => 'datetime',
        'locked_at' => 'datetime',
        'translations' => 'array',
    ];

    // ✅ Relationships
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function lockedBy()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function timeline()
    {
        return $this->hasMany(EvidenceTimeline::class, 'evidence_id');
    }

    public function shares()
    {
        return $this->hasMany(EvidenceShare::class, 'evidence_id');
    }

    // ✅ Generate Evidence ID
    public static function generateId(): string
    {
        $year = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;

        return 'EVD-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // ✅ Integrity check
    public function verifyIntegrity(): bool
    {
        if (! $this->file_path || ! $this->checksum) {
            return true;
        }

        $currentHash = hash_file('sha256', storage_path('app/'.$this->file_path));

        return $currentHash === $this->checksum;
    }

    // ✅ Scopes
    public function scopeForCase($query, string $type, int $id)
    {
        return $query->where('case_type', $type)->where('case_id', $id);
    }

    public function scopeLocked($query)
    {
        return $query->where('is_locked', true);
    }
}

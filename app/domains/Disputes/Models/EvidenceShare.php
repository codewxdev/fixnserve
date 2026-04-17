<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EvidenceShare extends Model
{
    use HasTranslations;

    public array $translatable = ['department', 'share_reason'];

    protected $fillable = [
        'evidence_id', 'shared_by', 'shared_with',
        'department', 'share_reason',
        'can_download', 'expires_at', 'translations',
    ];

    protected $casts = [
        'can_download' => 'boolean',
        'expires_at' => 'datetime',
        'translations' => 'array',
    ];

    public function evidence()
    {
        return $this->belongsTo(CaseEvidence::class, 'evidence_id');
    }

    public function sharedBy()
    {
        return $this->belongsTo(User::class, 'shared_by');
    }

    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }
}

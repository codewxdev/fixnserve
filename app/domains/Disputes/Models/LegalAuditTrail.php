<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class LegalAuditTrail extends Model
{
    use HasTranslations;

    public $timestamps = false;

    const UPDATED_AT = null;

    protected $fillable = [
        'legal_case_id', 'actor_id', 'action',
        'description', 'ip_address',
        'snapshot', 'created_at', 'translations',
    ];

    protected $casts = [
        'snapshot' => 'array',
        'translations' => 'array',
        'created_at' => 'datetime',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}

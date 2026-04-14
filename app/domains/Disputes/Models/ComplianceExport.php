<?php

namespace App\Domains\Disputes\Models;

use App\Domains\Security\Models\User;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class ComplianceExport extends Model
{
    use HasTranslations;

    protected $fillable = [
        'legal_case_id', 'export_type', 'export_format',
        'file_path', 'file_url', 'file_size', 'checksum',
        'generated_by', 'expires_at', 'is_encrypted',
        'included_sections', 'translations',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_encrypted' => 'boolean',
        'included_sections' => 'array',
        'translations' => 'array',
    ];

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class);
    }

    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}

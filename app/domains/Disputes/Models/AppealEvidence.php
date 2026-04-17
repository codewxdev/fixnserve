<?php

namespace App\Domains\Disputes\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AppealEvidence extends Model
{
    use HasTranslations;

    public array $translatable = ['description'];

    protected $table = 'appeal_evidences';

    protected $fillable = [
        'appeal_id', 'evidence_type',
        'file_path', 'file_url',
        'description', 'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    public function appeal()
    {
        return $this->belongsTo(Appeal::class);
    }
}

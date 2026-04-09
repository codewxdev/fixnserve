<?php

namespace App\Domains\Disputes\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AppealEvidence extends Model
{
    use HasTranslations;

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

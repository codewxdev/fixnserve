<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasTranslations;

    public array $translatable = ['action'];

    protected $fillable = [
        'admin_id',
        'action',
        'entity_type',
        'entity_id',
        'old_value',
        'new_value',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];
}

<?php

namespace App\Domains\Command\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EmergencyOverrideLog extends Model
{
    use HasTranslations;

    public array $translatable = ['action'];

    public $timestamps = false;

    protected $fillable = [
        'override_id',
        'admin_id',
        'action',
        'meta',
        'created_at',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}

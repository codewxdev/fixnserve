<?php

namespace App\Domains\Command\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EmergencyOverride extends Model
{
    use HasTranslations;

    public array $translatable = ['reason'];

    protected $fillable = [
        'admin_id',
        'expires_at',
        'active',
        'reason',
        'mfa_verified_at',
    ];
}

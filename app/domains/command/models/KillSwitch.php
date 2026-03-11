<?php

namespace App\Domains\Command\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class KillSwitch extends Model
{
    use HasTranslations;

    public array $translatable = ['reason'];

    protected $fillable = [
        'scope',
        'type',
        'reason',
        'expires_at',
        'created_by',
        'status',
    ];
}

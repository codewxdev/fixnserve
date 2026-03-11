<?php

namespace App\Domains\Command\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasTranslations;

    public array $translatable = ['reason', 'user_message'];

    protected $fillable = [
        'type',
        'module',
        'country_id',
        'reason',
        'user_message',
        'starts_at',
        'ends_at',
        'status',
        'created_by',

    ];
}

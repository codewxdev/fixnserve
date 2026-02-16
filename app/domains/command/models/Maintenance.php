<?php

namespace App\Domains\Command\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
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

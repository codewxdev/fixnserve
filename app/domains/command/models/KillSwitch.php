<?php

namespace App\Domains\Command\Models;

use Illuminate\Database\Eloquent\Model;

class KillSwitch extends Model
{
    protected $fillable = [
        'scope',
        'type',
        'reason',
        'expires_at',
        'created_by',
        'status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = [
        'provider_id',
        'subject',
        'priority',
        'status',
    ];
}

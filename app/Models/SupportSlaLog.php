<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportSlaLog extends Model
{
    protected $fillable = [
        'support_ticket_id',
        'tier',
        'sla_due_at',
        'breached_at',
    ];
}

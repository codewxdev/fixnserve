<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalAuditLog extends Model
{
    protected $fillable = [
        'dual_approval_id',
        'actor_id',
        'event',
        'ip_address',
        'user_agent',
    ];

    public function dualApproval()
    {
        return $this->belongsTo(DualApproval::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    protected $hidden = ['created_at', 'updated_at'];
}

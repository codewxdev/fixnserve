<?php

namespace App\Domains\Security\Models;

use Illuminate\Database\Eloquent\Model;

class DualApproval extends Model
{
    protected $table = 'dual_approval_requests';

    protected $fillable = [
        'action_type',
        'payload',
        'requested_by',
        'status',
        'approved_by_level_1',
        'approved_at_level_1',
        'approved_by_level_2',
        'approved_at_level_2',
        'justification',
        'expires_at',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'payload' => 'array',
        'expires_at' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approved_by_level_1');
    }

    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approved_by_level_2');
    }
}

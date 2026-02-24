<?php

namespace App\Domains\RBAC\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionAuditLog extends Model
{
    protected $fillable = [
        'actor_id',
        'event_type',
        'target_role',
        'permission',
        'old_value',
        'new_value',
        'justification',
        'approval_id',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}

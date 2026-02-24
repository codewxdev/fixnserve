<?php

namespace App\Domains\RBAC\Services;

use App\Domains\RBAC\Models\PermissionAuditLog;

class Audit
{
    public function log(array $data): void
    {
        PermissionAuditLog::create([
            'actor_id' => auth()->id(),
            'event_type' => $data['event_type'],
            'target_role' => $data['target_role'] ?? null,
            'permission' => $data['permission'] ?? null,
            'old_value' => $data['old_value'] ?? null,
            'new_value' => $data['new_value'] ?? null,
            'justification' => $data['justification'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}

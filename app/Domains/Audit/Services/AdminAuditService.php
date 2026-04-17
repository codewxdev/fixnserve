<?php

namespace App\Domains\Audit\Services;

use App\Domains\Audit\Models\AdminActionLog;

class AdminAuditService
{
    public function log(array $data): void
    {
        AdminActionLog::create([
            'admin_id' => auth()->id(),
            'admin_role' => auth()->user()->roles->first()->name ?? 'N/A',

            'action_type' => $data['action_type'],
            'target_type' => $data['target_type'] ?? null,
            'target_id' => $data['target_id'] ?? null,

            'before_state' => $data['before_state'] ?? null,
            'after_state' => $data['after_state'] ?? null,

            'reason_code' => $data['reason_code'],

            'ip_address' => request()->ip(),
            'device_fingerprint' => request()->header('X-Device-Fingerprint'),
            'user_agent' => request()->userAgent(),

            'performed_at' => now(),
        ]);
    }
}

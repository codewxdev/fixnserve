<?php

namespace App\Domains\Audit\Controllers\Api;

use App\Domains\Audit\Models\AdminActionLog;
use App\Domains\RBAC\Models\PermissionAuditLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuditAdminController extends Controller
{
    public function AdminAudit(Request $request)
    {
        $audits = AdminActionLog::with('user') // Assuming you have a relationship defined for the user who performed the action
            ->orderBy('performed_at', 'desc')->get();

        return response()->json($audits);
    }

    public function permissionAudit()
    {
        $audit = PermissionAuditLog::with('permission') // Assuming you have a relationship defined for the permission being audited
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($audit);
    }
}

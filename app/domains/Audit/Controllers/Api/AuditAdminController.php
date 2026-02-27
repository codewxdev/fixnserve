<?php

namespace App\Domains\Audit\Controllers\Api;

use App\Domains\Audit\Models\AdminActionLog;
use App\Domains\Audit\Models\SecurityAuditLog;
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

    public function overview()
    {
        $now = now();
        $last24 = now()->subDay();
        $prev24 = now()->subDays(2);

        /*
        |--------------------------------------------------------------------------
        | 1️⃣ FAILED LOGINS (24H)
        |--------------------------------------------------------------------------
        */

        $failedCurrent = SecurityAuditLog::where('event_type', 'login_failed')
            ->where('occurred_at', '>=', $last24)
            ->count();

        $failedPrevious = SecurityAuditLog::where('event_type', 'login_failed')
            ->whereBetween('occurred_at', [$prev24, $last24])
            ->count();

        $failedChange = $failedPrevious > 0
            ? round((($failedCurrent - $failedPrevious) / $failedPrevious) * 100)
            : 100;

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ MFA CHALLENGES
        |--------------------------------------------------------------------------
        */

        $mfaChallenges = SecurityAuditLog::where('event_type', 'mfa_challenge_triggered')
            ->where('occurred_at', '>=', $last24)
            ->count();

        $mfaSuccess = SecurityAuditLog::where('event_type', 'mfa_verified')
            ->where('occurred_at', '>=', $last24)
            ->count();

        $successRate = $mfaChallenges > 0
            ? round(($mfaSuccess / $mfaChallenges) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ TOKEN ROTATIONS
        |--------------------------------------------------------------------------
        */

        $tokenRotations = SecurityAuditLog::where('event_type', 'token_rotated')
            ->where('occurred_at', '>=', $last24)
            ->count();

        return response()->json([
            'failed_logins_24h' => [
                'count' => $failedCurrent,
                'percentage_change' => $failedChange,
            ],
            'mfa_challenges_24h' => [
                'count' => $mfaChallenges,
                'success_rate' => $successRate,
            ],
            'token_rotations_24h' => [
                'count' => $tokenRotations,
            ],
        ]);
    }
}

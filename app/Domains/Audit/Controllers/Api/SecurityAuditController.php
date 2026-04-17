<?php

namespace App\Domains\Audit\Controllers\Api;

use App\Domains\Audit\Models\AccessPolicyChange;
use App\Domains\Audit\Models\PrivilegeUsageLog;
use App\Domains\Audit\Models\SecurityAnomaly;
use App\Domains\Audit\Models\SecurityAuditLog;
use App\Domains\Audit\Services\SecurityAuditService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class SecurityAuditController extends BaseApiController
{
    public function __construct(
        protected SecurityAuditService $auditService
    ) {}

    // ✅ 1. Dashboard
    // Purpose: Security overview - anomalies, failed logins, flags
    // When: Admin opens security module
    public function dashboard()
    {
        return $this->success(
            $this->auditService->getDashboardStats(),
            'security_dashboard_fetched'
        );
    }

    // ✅ 2. Audit Logs
    // Purpose: View all security events with filters
    // When: Investigating a security incident
    public function auditLogs(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|integer',
            'event_type' => 'nullable|string',
            'ip_address' => 'nullable|ip',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'success' => 'nullable|boolean',
            'anomaly' => 'nullable|boolean',
        ]);

        $logs = SecurityAuditLog::with('user:id,name')
            ->when($request->user_id,
                fn ($q) => $q->byUser($request->user_id)
            )
            ->when($request->event_type,
                fn ($q) => $q->where('event_type', $request->event_type)
            )
            ->when($request->ip_address,
                fn ($q) => $q->byIp($request->ip_address)
            )
            ->when($request->has('success'),
                fn ($q) => $q->where('success', $request->success)
            )
            ->when($request->anomaly,
                fn ($q) => $q->anomalies()
            )
            ->when($request->from && $request->to,
                fn ($q) => $q->whereBetween('occurred_at', [
                    $request->from.' 00:00:00',
                    $request->to.' 23:59:59',
                ])
            )
            ->orderByDesc('occurred_at')
            ->paginate(20);

        return $this->success($logs, 'audit_logs_fetched');
    }

    // ✅ 3. Single Log Detail
    // Purpose: Full detail of one security event
    // When: Deep dive into specific incident
    public function showLog(SecurityAuditLog $log)
    {
        return $this->success(
            $log->load('user:id,name,email'),
            'audit_log_fetched'
        );
    }

    // ✅ 4. User Security Timeline
    // Purpose: All security events for one user chronologically
    // When: Investigating compromised account
    public function userTimeline(int $userId)
    {
        $events = SecurityAuditLog::byUser($userId)
            ->with('user:id,name')
            ->orderByDesc('occurred_at')
            ->paginate(30);

        $summary = [
            'total_logins' => SecurityAuditLog::byUser($userId)
                ->where('event_type', 'login_success')->count(),
            'failed_logins' => SecurityAuditLog::byUser($userId)
                ->where('event_type', 'login_failed')->count(),
            'anomalies' => SecurityAuditLog::byUser($userId)
                ->anomalies()->count(),
            'active_sessions' => DB::table('user_sessions')
                ->where('user_id', $userId)
                ->whereNull('revoked_at')
                ->count(),
            'last_login' => SecurityAuditLog::byUser($userId)
                ->where('event_type', 'login_success')
                ->latest('occurred_at')
                ->first()?->occurred_at?->diffForHumans(),
        ];

        return $this->success([
            'user_id' => $userId,
            'summary' => $summary,
            'events' => $events,
        ], 'user_timeline_fetched');
    }

    // ✅ 5. All Anomalies
    // Purpose: List of detected security anomalies
    // When: Daily security review
    public function anomalies(Request $request)
    {
        $anomalies = SecurityAnomaly::with('user:id,name', 'reviewedBy:id,name')
            ->when($request->status,
                fn ($q) => $q->where('status', $request->status)
            )
            ->when($request->severity,
                fn ($q) => $q->where('severity', $request->severity)
            )
            ->when($request->type,
                fn ($q) => $q->where('anomaly_type', $request->type)
            )
            ->when(! $request->status, fn ($q) => $q->open())
            ->latest()
            ->paginate(20);

        return $this->success($anomalies, 'anomalies_fetched');
    }

    // ✅ 6. Investigate Anomaly
    // Purpose: Mark anomaly as under investigation
    // When: Security team picks up a case
    public function investigateAnomaly(
        Request $request,
        SecurityAnomaly $anomaly
    ) {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $anomaly->update([
            'status' => 'investigating',
            'reviewed_by' => auth()->id(),
        ]);

        $this->auditService->logEvent(
            eventType: 'suspicious_activity',
            userId: auth()->id(),
            meta: ['anomaly_id' => $anomaly->anomaly_id, 'notes' => $request->notes]
        );

        return $this->success($anomaly->fresh(), 'anomaly_investigating');
    }

    // ✅ 7. Resolve Anomaly
    // Purpose: Close anomaly as confirmed or false positive
    // When: Investigation complete
    public function resolveAnomaly(
        Request $request,
        SecurityAnomaly $anomaly
    ) {
        $request->validate([
            'resolution' => 'required|in:confirmed,false_positive,resolved',
            'notes' => 'required|string|max:500',
        ]);

        $anomaly->update([
            'status' => $request->resolution,
            'reviewed_by' => auth()->id(),
        ]);

        return $this->success($anomaly->fresh(), 'anomaly_resolved');
    }

    // ✅ 8. Privilege Logs
    // Purpose: Admin actions audit trail
    // When: Compliance review, privilege abuse investigation
    public function privilegeLogs(Request $request)
    {
        $logs = PrivilegeUsageLog::with('user:id,name')
            ->when($request->user_id,
                fn ($q) => $q->byUser($request->user_id)
            )
            ->when($request->action_type,
                fn ($q) => $q->where('action_type', $request->action_type)
            )
            ->when($request->suspicious,
                fn ($q) => $q->suspicious()
            )
            ->latest()
            ->paginate(20);

        return $this->success($logs, 'privilege_logs_fetched');
    }

    // ✅ 9. Policy Changes
    // Purpose: IP/device policy change history
    // When: Auditing who changed what security rule
    public function policyChanges(Request $request)
    {
        $changes = AccessPolicyChange::with('changedBy:id,name')
            ->when($request->policy_type,
                fn ($q) => $q->where('policy_type', $request->policy_type)
            )
            ->latest()
            ->paginate(20);

        return $this->success($changes, 'policy_changes_fetched');
    }

    // ✅ 10. IP Activity
    // Purpose: All activity from specific IP
    // When: Investigating suspicious IP
    public function ipActivity(string $ip)
    {
        $logs = SecurityAuditLog::byIp($ip)
            ->with('user:id,name')
            ->orderByDesc('occurred_at')
            ->paginate(20);

        $summary = [
            'total_events' => SecurityAuditLog::byIp($ip)->count(),
            'failed_logins' => SecurityAuditLog::byIp($ip)->failed()->count(),
            'unique_users' => SecurityAuditLog::byIp($ip)
                ->whereNotNull('user_id')
                ->distinct('user_id')->count(),
            'is_blocked' => DB::table('ip_blocks')
                ->where('ip_address', $ip)
                ->where('is_active', true)->exists(),
            'anomalies' => SecurityAnomaly::where('ip_address', $ip)->count(),
        ];

        return $this->success([
            'ip' => $ip,
            'summary' => $summary,
            'events' => $logs,
        ], 'ip_activity_fetched');
    }

    // ✅ 11. Failed Login Report
    // Purpose: Bulk failed login analysis
    // When: Brute force investigation
    public function failedLoginReport(Request $request)
    {
        $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $from = $request->from ?? today()->format('Y-m-d');
        $to = $request->to ?? today()->format('Y-m-d');

        $byIp = SecurityAuditLog::where('event_type', 'login_failed')
            ->whereBetween('occurred_at', ["{$from} 00:00:00", "{$to} 23:59:59"])
            ->select('ip_address', DB::raw('count(*) as count'))
            ->groupBy('ip_address')
            ->orderByDesc('count')
            ->limit(20)
            ->get();

        $byUser = SecurityAuditLog::where('event_type', 'login_failed')
            ->whereBetween('occurred_at', ["{$from} 00:00:00", "{$to} 23:59:59"])
            ->whereNotNull('user_id')
            ->select('user_id', 'user_ref', DB::raw('count(*) as count'))
            ->groupBy('user_id', 'user_ref')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return $this->success([
            'period' => ['from' => $from, 'to' => $to],
            'total_failed' => SecurityAuditLog::where('event_type', 'login_failed')
                ->whereBetween('occurred_at', ["{$from} 00:00:00", "{$to} 23:59:59"])
                ->count(),
            'by_ip' => $byIp,
            'by_user' => $byUser,
        ], 'failed_login_report_fetched');
    }

    // ✅ 12. Export Security Logs
    // Purpose: CSV for compliance/legal
    // When: Regulator request, legal case
    public function exportLogs(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date',
        ]);

        $logs = SecurityAuditLog::whereBetween('occurred_at', [
            $request->from.' 00:00:00',
            $request->to.' 23:59:59',
        ])->orderByDesc('occurred_at')->get();

        $filename = "security_audit_{$request->from}_{$request->to}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Log ID', 'User', 'Role', 'Event',
                'IP', 'Country', 'Success',
                'Anomaly', 'Risk Score', 'Occurred At',
            ]);
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->log_id,
                    $log->user_ref ?? 'Guest',
                    $log->user_role ?? 'N/A',
                    $log->event_type,
                    $log->ip_address,
                    $log->country ?? 'N/A',
                    $log->success ? 'Yes' : 'No',
                    $log->is_anomaly ? 'Yes' : 'No',
                    $log->risk_score,
                    $log->occurred_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

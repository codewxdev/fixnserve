<?php

namespace App\Domains\Audit\Services;

use App\Domains\Audit\Models\AccessPolicyChange;
use App\Domains\Audit\Models\PrivilegeUsageLog;
use App\Domains\Audit\Models\SecurityAnomaly;
use App\Domains\Audit\Models\SecurityAuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SecurityAuditService
{
    protected $riskEngine;

    public function __construct(SecurityRiskEngine $riskEngine)
    {
        $this->riskEngine = $riskEngine;
    }

    // ═══════════════════════════════════════
    // EXISTING METHOD - UPDATED
    // ═══════════════════════════════════════

    public function log(
        string $eventType,
        array $data = [],
        $user = null,
        bool $success = true,
        ?string $failReason = null
    ): SecurityAuditLog {

        // ✅ Risk engine existing hai - use karo
        $risk = $this->riskEngine->evaluate($eventType, $user);
        $isAnomaly = $this->riskEngine->isAnomaly($risk);

        // ✅ Get session data from user_sessions table

        $sessionData = $this->getSessionData($user);

        $log = SecurityAuditLog::create([
            // ✅ Existing fields
            'user_id' => $user?->id,
            'event_type' => $eventType,
            'risk_score' => $risk,
            'is_anomaly' => $isAnomaly,
            'event_data' => $data,
            'occurred_at' => now(),

            // ✅ From user_sessions table (already stored)
            'ip_address' => $sessionData['ip_address'],
            'device' => $sessionData['device'],
            'session_id' => $sessionData['session_id'],

            // ✅ New fields
            'log_id' => SecurityAuditLog::generateId(),
            'user_ref' => $this->getUserRef($user),
            'user_role' => $user?->getRoleNames()->first(),
            'success' => $success,
            'failure_reason' => $failReason,
            'checksum' => $this->generateChecksum($user, $eventType),
        ]);
        // dd('Logging event: '.$eventType);

        // ✅ Existing alert logic
        if ($isAnomaly) {
            $this->triggerAlert($log);
        }

        // ✅ NEW: Create anomaly record
        if ($isAnomaly) {
            $this->createAnomalyRecord($log, $sessionData);
        }

        return $log;
    }

    // ═══════════════════════════════════════
    // GET SESSION DATA
    // ═══════════════════════════════════════

    private function getSessionData($user): array
    {
        if (! $user) {
            // ✅ Guest user - use request data directly
            return [
                'ip_address' => request()->ip(),
                'device' => request()->userAgent(),
                'session_id' => null,
                'country' => null,
                'latitude' => null,
                'longitude' => null,
            ];
        }

        // ✅ Existing user ka latest session from DB
        $session = DB::table('user_sessions')
            ->where('user_id', $user->id)
            ->whereNull('revoked_at')
            ->where('expires_at', '>', now())
            ->latest('last_activity_at')
            ->first();

        if ($session) {
            return [
                // ✅ Already in user_sessions - use directly
                'ip_address' => $session->ip_address,
                'device' => $session->device,
                'session_id' => $session->id,
                'country' => $session->country,
                'latitude' => $session->latitude,
                'longitude' => $session->longitude,
            ];
        }

        // ✅ No session found - use request data
        return [
            'ip_address' => request()->ip(),
            'device' => request()->userAgent(),
            'session_id' => null,
            'country' => null,
            'latitude' => null,
            'longitude' => null,
        ];
    }

    // ═══════════════════════════════════════
    // CREATE ANOMALY RECORD
    // New table mein store karo
    // ═══════════════════════════════════════

    private function createAnomalyRecord(
        SecurityAuditLog $log,
        array $sessionData
    ): void {

        $anomalyType = $this->determineAnomalyType($log);
        if (! $anomalyType) {
            return;
        }

        $anomaly = SecurityAnomaly::create([
            'anomaly_id' => SecurityAnomaly::generateId(),
            'user_id' => $log->user_id,
            'user_ref' => $log->user_ref,
            'ip_address' => $log->ip_address,
            'anomaly_type' => $anomalyType,
            'description' => $this->getAnomalyDescription($anomalyType, $log),
            'confidence_score' => $log->risk_score,
            'severity' => $this->getSeverity($log->risk_score),
            'status' => 'detected',
            'evidence' => [
                'event_type' => $log->event_type,
                'event_data' => $log->event_data,
                'session_data' => $sessionData,
            ],
        ]);

        // ✅ Auto action on critical
        if ($anomaly->severity === 'critical') {
            $this->autoActionAnomaly($anomaly);
        }

        // ✅ Sync to Risk Module 13
        $this->syncToRiskModule($anomaly);
    }

    private function determineAnomalyType(SecurityAuditLog $log): ?string
    {
        return match ($log->event_type) {
            'login_failed' => 'brute_force',
            'login_success' => 'concurrent_sessions',
            'token_issued' => 'token_replay',
            'session_created' => 'geo_anomaly',
            'privilege_escalated' => 'privilege_abuse',
            default => 'unusual_time_access',
        };
    }

    private function getSeverity(int $riskScore): string
    {
        return match (true) {
            $riskScore >= 90 => 'critical',
            $riskScore >= 70 => 'high',
            $riskScore >= 50 => 'medium',
            default => 'low',
        };
    }

    private function getAnomalyDescription(
        string $type,
        SecurityAuditLog $log
    ): string {
        return match ($type) {
            'brute_force' => "Failed login attempts from {$log->ip_address}",
            'concurrent_sessions' => "Multiple sessions detected for user {$log->user_ref}",
            'token_replay' => 'Token used from new location',
            'privilege_abuse' => "Unusual privilege usage by {$log->user_ref}",
            default => "Security anomaly: {$log->event_type}",
        };
    }

    // ═══════════════════════════════════════
    // AUTO ACTION
    // ═══════════════════════════════════════

    private function autoActionAnomaly(SecurityAnomaly $anomaly): void
    {
        match ($anomaly->anomaly_type) {
            'brute_force' => $this->blockIpAuto($anomaly->ip_address),
            'concurrent_sessions' => $this->revokeExcessSessions($anomaly->user_id),
            'token_replay' => $this->revokeUserTokens($anomaly->user_id),
            default => null,
        };

        $anomaly->update([
            'auto_actioned' => true,
            'auto_action_taken' => "Auto: {$anomaly->anomaly_type} handled",
        ]);
    }

    private function blockIpAuto(string $ip): void
    {
        DB::table('ip_blocks')->updateOrInsert(
            ['ip_address' => $ip],
            [
                'type' => 'bot',
                'reason' => 'Auto: Anomaly detected',
                'is_active' => true,
                'block_count' => DB::raw('block_count + 1'),
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }

    private function revokeExcessSessions(int $userId): void
    {
        // Keep only the latest session
        $latestId = DB::table('user_sessions')
            ->where('user_id', $userId)
            ->whereNull('revoked_at')
            ->orderByDesc('last_activity_at')
            ->value('id');

        DB::table('user_sessions')
            ->where('user_id', $userId)
            ->whereNull('revoked_at')
            ->where('id', '!=', $latestId)
            ->update(['revoked_at' => now()]);
    }

    private function revokeUserTokens(int $userId): void
    {
        DB::table('user_sessions')
            ->where('user_id', $userId)
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
    }

    // ✅ Sync to Risk Module 13
    private function syncToRiskModule(SecurityAnomaly $anomaly): void
    {
        if (! $anomaly->user_id) {
            return;
        }

        DB::table('risk_events')->insert([
            'entity_type' => 'user',
            'entity_id' => $anomaly->user_id,
            'event_type' => "security_{$anomaly->anomaly_type}",
            'event_data' => json_encode($anomaly->evidence),
            'score_before' => 0,
            'score_after' => 0,
            'score_delta' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // ═══════════════════════════════════════
    // PRIVILEGE LOGGING
    // New method - admin actions ke liye
    // ═══════════════════════════════════════

    public function logPrivilege(
        int $userId,
        string $userRole,
        string $actionType,
        string $resourceType,
        string $description,
        ?int $resourceId = null,
        ?string $resourceRef = null,
        array $meta = []
    ): PrivilegeUsageLog {

        // ✅ Session se IP lo
        $session = DB::table('user_sessions')
            ->where('user_id', $userId)
            ->whereNull('revoked_at')
            ->latest()
            ->first();

        $suspicious = $this->isPrivilegeSuspicious(
            $userId, $actionType
        );

        return PrivilegeUsageLog::create([
            'user_id' => $userId,
            'user_role' => $userRole,
            'action_type' => $actionType,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId,
            'resource_ref' => $resourceRef,
            'description' => $description,
            'ip_address' => $session?->ip_address ?? request()->ip(),
            'endpoint' => request()->path(),
            'is_authorized' => true,
            'is_suspicious' => $suspicious,
            'before_state' => $meta['before'] ?? null,
            'after_state' => $meta['after'] ?? null,
        ]);
    }

    private function isPrivilegeSuspicious(int $userId, string $actionType): bool
    {
        return PrivilegeUsageLog::where('user_id', $userId)
            ->where('action_type', $actionType)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->count() >= 10;
    }

    // ✅ Policy Change Logging
    public function logPolicyChange(
        string $policyType,
        string $targetValue,
        string $targetType,
        array $oldValue,
        array $newValue,
        string $reason,
        ?int $targetUserId = null
    ): AccessPolicyChange {

        $session = DB::table('user_sessions')
            ->where('user_id', auth()->id())
            ->whereNull('revoked_at')
            ->latest()
            ->first();

        return AccessPolicyChange::create([
            'changed_by' => auth()->id(),
            'policy_type' => $policyType,
            'target_value' => $targetValue,
            'target_type' => $targetType,
            'target_user_id' => $targetUserId,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'reason' => $reason,
            'ip_address' => $session?->ip_address ?? request()->ip(),
        ]);
    }

    // ═══════════════════════════════════════
    // EXISTING METHOD - Keep as is
    // ═══════════════════════════════════════

    protected function triggerAlert($log): void
    {
        Log::warning('SECURITY ANOMALY DETECTED', [
            'event' => $log->event_type,
            'risk_score' => $log->risk_score,
            'user_id' => $log->user_id,
        ]);
    }

    // ═══════════════════════════════════════
    // HELPERS
    // ═══════════════════════════════════════

    private function getUserRef($user): ?string
    {
        if (! $user) {
            return null;
        }
        $prefix = match (true) {
            $user->hasRole('customer') => 'C',
            $user->hasRole('rider') => 'R',
            $user->hasRole('mart_vendor') => 'V',
            $user->hasRole('service_provider') => 'P',
            $user->hasRole('Super Admin') => 'A',
            default => 'U',
        };

        return "{$prefix}-{$user->id}";
    }

    private function generateChecksum($user, string $eventType): string
    {
        return hash('sha256', json_encode([
            $user?->id,
            $eventType,
            request()->ip(),
            now()->toDateTimeString(),
        ]));
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        return [
            'today' => [
                'total_events' => SecurityAuditLog::today()->count(),
                'failed_logins' => SecurityAuditLog::today()->failed()
                    ->where('event_type', 'login_failed')->count(),
                'anomalies' => SecurityAuditLog::today()->anomalies()->count(),
            ],
            'anomalies' => [
                'open' => SecurityAnomaly::whereIn('status', ['detected', 'investigating'])->count(),
                'critical' => SecurityAnomaly::where('severity', 'critical')
                    ->whereIn('status', ['detected', 'investigating'])->count(),
            ],
            'privilege' => [
                'suspicious' => PrivilegeUsageLog::where('is_suspicious', true)->count(),
            ],
            'policy_changes_today' => AccessPolicyChange::whereDate('created_at', today())->count(),
        ];
    }
}

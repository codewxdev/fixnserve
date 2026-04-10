<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\EscalationEvent;
use App\Domains\Disputes\Models\EscalationRule;
use App\Domains\Disputes\Models\SlaLevelConfig;
use App\Domains\Disputes\Models\SlaTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SlaEscalationService
{
    // ═══════════════════════════════════════
    // CREATE SLA TRACKING
    // Called when complaint/appeal created
    // ═══════════════════════════════════════

    public function createTracking(
        string $trackableType,
        int $trackableId,
        string $caseRef,
        string $slaLevel = 'standard',
        ?int $assigneeId = null
    ): SlaTracking {

        $config = SlaLevelConfig::getForLevel($slaLevel);

        $tracking = SlaTracking::create([
            'trackable_type' => $trackableType,
            'trackable_id' => $trackableId,
            'case_ref' => $caseRef,
            'sla_level' => $slaLevel,
            'started_at' => now(),
            'first_response_due' => now()->addHours($config->first_response_hours),
            'resolution_due' => now()->addHours($config->resolution_hours),
            'current_assignee_role' => 'support_agent',
            'current_assignee_id' => $assigneeId,
            'escalation_level' => 0,
            'escalation_history' => [],
        ]);

        Log::info("⏱️ SLA tracking started: {$caseRef}", [
            'level' => $slaLevel,
            'resolution_due' => $tracking->resolution_due,
        ]);

        return $tracking;
    }

    // ═══════════════════════════════════════
    // CHECK & PROCESS BREACHES
    // Called by scheduled command
    // ═══════════════════════════════════════

    public function checkBreaches(): array
    {
        $results = [
            'breached' => 0,
            'approaching' => 0,
            'escalated' => 0,
        ];

        // ✅ Check first response breaches
        $firstResponseBreached = SlaTracking::active()
            ->where('first_response_breached', false)
            ->whereNull('first_response_at')
            ->where('first_response_due', '<', now())
            ->get();

        foreach ($firstResponseBreached as $tracking) {
            $tracking->update([
                'first_response_breached' => true,
                'breach_count' => $tracking->breach_count + 1,
            ]);
            $results['breached']++;

            Log::warning("🚨 First response SLA breached: {$tracking->case_ref}");
        }

        // ✅ Check resolution breaches
        $resolutionBreached = SlaTracking::active()
            ->where('resolution_breached', false)
            ->where('resolution_due', '<', now())
            ->get();

        foreach ($resolutionBreached as $tracking) {
            $tracking->update([
                'resolution_breached' => true,
                'breach_count' => $tracking->breach_count + 1,
            ]);

            // ✅ Auto escalate on breach
            $this->autoEscalate($tracking, 'auto_breach');
            $results['breached']++;
            $results['escalated']++;
        }

        // ✅ Check approaching breaches (1hr warning)
        $approaching = SlaTracking::approaching()->get();

        foreach ($approaching as $tracking) {
            $this->notifyApproachingBreach($tracking);
            $results['approaching']++;
        }

        return $results;
    }

    // ═══════════════════════════════════════
    // AUTO ESCALATE
    // ═══════════════════════════════════════

    public function autoEscalate(
        SlaTracking $tracking,
        string $triggerType
    ): SlaTracking {

        // ✅ Get escalation path
        $escalationPath = [
            0 => ['role' => 'support_agent',  'next' => 'senior_ops'],
            1 => ['role' => 'senior_ops',     'next' => 'finance'],
            2 => ['role' => 'finance',         'next' => 'legal'],
            3 => ['role' => 'legal',           'next' => null], // terminal
        ];

        $currentLevel = $tracking->escalation_level;
        $nextPath = $escalationPath[$currentLevel] ?? null;

        if (! $nextPath || ! $nextPath['next']) {
            Log::warning("⚠️ Max escalation reached: {$tracking->case_ref}");

            return $tracking;
        }

        $fromRole = $nextPath['role'];
        $toRole = $nextPath['next'];

        // ✅ Check escalation rule
        $rule = EscalationRule::active()
            ->where('from_role', $fromRole)
            ->where('to_role', $toRole)
            ->where('auto_escalate', true)
            ->first();

        if (! $rule) {
            return $tracking;
        }

        // ✅ Find new assignee
        $newAssignee = $this->findAvailableAssignee($toRole);

        // ✅ Log escalation event
        EscalationEvent::create([
            'sla_tracking_id' => $tracking->id,
            'from_role' => $fromRole,
            'to_role' => $toRole,
            'from_assignee' => $tracking->current_assignee_id,
            'to_assignee' => $newAssignee?->id,
            'trigger_type' => $triggerType,
            'notes' => "Auto escalated: {$tracking->case_ref}",
            'triggered_by' => null, // system
        ]);

        // ✅ Update history
        $history = $tracking->escalation_history ?? [];
        $history[] = [
            'from' => $fromRole,
            'to' => $toRole,
            'at' => now()->toDateTimeString(),
            'trigger' => $triggerType,
            'assignee' => $newAssignee?->name,
        ];

        // ✅ Update tracking
        $tracking->update([
            'escalation_level' => $currentLevel + 1,
            'current_assignee_role' => $toRole,
            'current_assignee_id' => $newAssignee?->id,
            'escalation_history' => $history,
        ]);

        Log::warning("🔺 Escalated {$tracking->case_ref}: {$fromRole} → {$toRole}");

        return $tracking->fresh();
    }

    // ═══════════════════════════════════════
    // MANUAL ESCALATE
    // ═══════════════════════════════════════

    public function manualEscalate(
        SlaTracking $tracking,
        string $toRole,
        int $toAssigneeId,
        string $notes,
        int $triggeredBy
    ): SlaTracking {

        $fromRole = $tracking->current_assignee_role;

        EscalationEvent::create([
            'sla_tracking_id' => $tracking->id,
            'from_role' => $fromRole,
            'to_role' => $toRole,
            'from_assignee' => $tracking->current_assignee_id,
            'to_assignee' => $toAssigneeId,
            'trigger_type' => 'manual',
            'notes' => $notes,
            'triggered_by' => $triggeredBy,
        ]);

        $history = $tracking->escalation_history ?? [];
        $history[] = [
            'from' => $fromRole,
            'to' => $toRole,
            'at' => now()->toDateTimeString(),
            'trigger' => 'manual',
            'notes' => $notes,
        ];

        $newLevel = match ($toRole) {
            'support_agent' => 0,
            'senior_ops' => 1,
            'finance' => 2,
            'legal' => 3,
            default => $tracking->escalation_level,
        };

        $tracking->update([
            'escalation_level' => $newLevel,
            'current_assignee_role' => $toRole,
            'current_assignee_id' => $toAssigneeId,
            'escalation_history' => $history,
        ]);

        Log::info("🔺 Manual escalation: {$tracking->case_ref} → {$toRole}");

        return $tracking->fresh();
    }

    // ✅ Notify approaching breach
    private function notifyApproachingBreach(SlaTracking $tracking): void
    {
        Log::warning("⏰ SLA approaching breach: {$tracking->case_ref}", [
            'due_in' => $tracking->time_remaining,
            'assignee' => $tracking->current_assignee_id,
        ]);
        // Send notification to assignee
    }

    // ✅ Find available assignee for role
    private function findAvailableAssignee(string $role): ?object
    {
        return DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', $role)
            ->select('users.id', 'users.name')
            ->first();
    }

    // ✅ Mark resolved
    public function markResolved(
        string $trackableType,
        int $trackableId
    ): void {

        SlaTracking::where('trackable_type', $trackableType)
            ->where('trackable_id', $trackableId)
            ->whereNull('resolved_at')
            ->update(['resolved_at' => now()]);
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        return [
            'sla_breaching_soon' => SlaTracking::approaching()->count(),
            'breached' => SlaTracking::breached()->count(),
            'active' => SlaTracking::active()->count(),
            'by_level' => [
                'standard' => SlaTracking::active()
                    ->where('sla_level', 'standard')->count(),
                'priority' => SlaTracking::active()
                    ->where('sla_level', 'priority')->count(),
                'legal' => SlaTracking::active()
                    ->where('sla_level', 'legal')->count(),
            ],
            'by_escalation' => [
                'support_agent' => SlaTracking::active()
                    ->where('current_assignee_role', 'support_agent')->count(),
                'senior_ops' => SlaTracking::active()
                    ->where('current_assignee_role', 'senior_ops')->count(),
                'finance' => SlaTracking::active()
                    ->where('current_assignee_role', 'finance')->count(),
                'legal' => SlaTracking::active()
                    ->where('current_assignee_role', 'legal')->count(),
            ],
        ];
    }
}

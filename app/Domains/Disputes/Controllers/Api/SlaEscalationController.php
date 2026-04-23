<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\EscalationEvent;
use App\Domains\Disputes\Models\EscalationRule;
use App\Domains\Disputes\Models\SlaLevelConfig;
use App\Domains\Disputes\Models\SlaTracking;
use App\Domains\Disputes\Services\SlaEscalationService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class SlaEscalationController extends BaseApiController
{
    public function __construct(
        protected SlaEscalationService $slaService
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->slaService->getDashboardStats(),
            'sla_dashboard_fetched'
        );
    }

    // ✅ 2. All SLA Trackings
    public function index(Request $request)
    {
        $trackings = SlaTracking::with('currentAssignee:id,name')
            ->when($request->sla_level, fn ($q) => $q->where('sla_level', $request->sla_level))
            ->when($request->breached, fn ($q) => $q->breached())
            ->when($request->approaching, fn ($q) => $q->approaching())
            ->when($request->role, fn ($q) => $q->where('current_assignee_role', $request->role))
            ->active()
            ->orderBy('resolution_due')
            ->paginate(20)
            ->through(function ($tracking) {
                return [
                    'id' => $tracking->id,
                    'case_ref' => $tracking->case_ref,
                    'sla_level' => $tracking->sla_level,
                    'time_remaining' => $tracking->time_remaining,
                    'resolution_due' => $tracking->resolution_due,
                    'resolution_breached' => $tracking->resolution_breached,
                    'escalation_level' => $tracking->escalation_level,
                    'current_role' => $tracking->current_assignee_role,
                    'assignee' => $tracking->currentAssignee?->name,
                    'breach_count' => $tracking->breach_count,
                ];
            });

        return $this->success($trackings, 'sla_trackings_fetched');
    }

    // ✅ 3. Single Tracking Detail
    public function show(SlaTracking $slaTracking)
    {
        return $this->success(
            $slaTracking->load([
                'currentAssignee:id,name',
                'escalationEvents.fromAssignee:id,name',
                'escalationEvents.toAssignee:id,name',
            ]),
            'sla_tracking_fetched'
        );
    }

    // ✅ 4. Manual Escalate
    public function escalate(Request $request, SlaTracking $slaTracking)
    {
        $request->validate([
            'to_role' => 'required|in:support_agent,senior_ops,finance,legal',
            'to_assignee' => 'required|exists:users,id',
            'notes' => 'required|string|max:500',
        ]);

        $result = $this->slaService->manualEscalate(
            tracking: $slaTracking,
            toRole: $request->to_role,
            toAssigneeId: $request->to_assignee,
            notes: $request->notes,
            triggeredBy: auth()->id()
        );

        return $this->success($result, 'manually_escalated');
    }

    // ✅ 5. Supervisor Intervention
    public function supervisorIntervene(
        Request $request,
        SlaTracking $slaTracking
    ) {
        $request->validate([
            'action' => 'required|in:reassign,reprioritize,resolve',
            'assignee_id' => 'nullable|exists:users,id',
            'sla_level' => 'nullable|in:standard,priority,legal',
            'notes' => 'required|string|max:500',
        ]);

        match ($request->action) {
            'reassign' => $this->slaService->manualEscalate(
                tracking: $slaTracking,
                toRole: $slaTracking->current_assignee_role,
                toAssigneeId: $request->assignee_id,
                notes: "Supervisor reassign: {$request->notes}",
                triggeredBy: auth()->id()
            ),
            'reprioritize' => $slaTracking->update([
                'sla_level' => $request->sla_level ?? $slaTracking->sla_level,
            ]),
            'resolve' => $this->slaService->markResolved(
                $slaTracking->trackable_type,
                $slaTracking->trackable_id
            ),
        };

        return $this->success(
            $slaTracking->fresh(),
            'supervisor_intervention_applied'
        );
    }

    // ✅ 6. Get Escalation History
    public function escalationHistory(SlaTracking $slaTracking)
    {
        $events = EscalationEvent::where('sla_tracking_id', $slaTracking->id)
            ->with([
                'fromAssignee:id,name',
                'toAssignee:id,name',
            ])
            ->latest()
            ->get();

        return $this->success([
            'tracking' => $slaTracking,
            'history' => $events,
        ], 'escalation_history_fetched');
    }

    // ✅ 7. Get SLA Level Configs
    public function getSlaConfigs()
    {
        $configs = SlaLevelConfig::all();

        return $this->success($configs, 'sla_configs_fetched');
    }

    // ✅ 8. Update SLA Config
    public function updateSlaConfig(
        Request $request,
        SlaLevelConfig $config
    ) {
        $data = $request->validate([
            'first_response_hours' => 'sometimes|integer|min:1',
            'resolution_hours' => 'sometimes|integer|min:1',
            'approaching_alert_hours' => 'sometimes|integer|min:1',
            'requires_supervisor' => 'sometimes|boolean',
            'requires_legal_review' => 'sometimes|boolean',
        ]);

        $config->update($data);

        return $this->success($config, 'sla_config_updated');
    }

    // ✅ 9. Get Escalation Rules
    public function getEscalationRules()
    {
        $rules = EscalationRule::active()->get();

        return $this->success($rules, 'escalation_rules_fetched');
    }

    // ✅ 10. Update Escalation Rule
    public function updateEscalationRule(
        Request $request,
        EscalationRule $rule
    ) {
        $data = $request->validate([
            'trigger_after_hours' => 'sometimes|integer|min:1',
            'auto_escalate' => 'sometimes|boolean',
            'notify_supervisor' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        $rule->update($data);

        return $this->success($rule, 'escalation_rule_updated');
    }

    // ✅ 11. Breached Cases
    public function breachedCases()
    {
        $breached = SlaTracking::breached()
            ->with('currentAssignee:id,name')
            ->orderByDesc('breach_count')
            ->get()
            ->map(function ($tracking) {
                return [
                    'case_ref' => $tracking->case_ref,
                    'sla_level' => $tracking->sla_level,
                    'breached_since' => $tracking->resolution_due->diffForHumans(),
                    'breach_count' => $tracking->breach_count,
                    'escalation_level' => $tracking->escalation_level,
                    'current_role' => $tracking->current_assignee_role,
                    'assignee' => $tracking->currentAssignee?->name,
                ];
            });

        return $this->success($breached, 'breached_cases_fetched');
    }

    // ✅ 12. Force Check Breaches (Manual trigger)
    public function checkBreaches()
    {
        $results = $this->slaService->checkBreaches();

        return $this->success([
            'checked_at' => now()->toDateTimeString(),
            'breached' => $results['breached'],
            'approaching' => $results['approaching'],
            'escalated' => $results['escalated'],
        ], 'breach_check_completed');
    }
}

<?php

namespace App\Domains\Disputes\Controllers\Api;

use App\Domains\Disputes\Models\ClassificationRule;
use App\Domains\Disputes\Models\Complaint;
use App\Domains\Disputes\Models\SlaConfig;
use App\Domains\Disputes\Services\ComplaintClassificationService;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ComplaintIntakeController extends BaseApiController
{
    public function __construct(
        protected ComplaintClassificationService $classifier
    ) {}

    // ✅ 1. Dashboard
    public function dashboard()
    {
        return $this->success(
            $this->classifier->getDashboardStats(),
            'complaint_dashboard_fetched'
        );
    }

    // ✅ 2. Priority Queue
    public function priorityQueue(Request $request)
    {
        $request->validate([
            'sort' => 'nullable|in:sla_urgency,severity,created_at',
            'classification' => 'nullable|string',
            'severity' => 'nullable|in:low,medium,high,critical',
            'status' => 'nullable|string',
        ]);

        $query = Complaint::with('assignedTo:id,name')
            ->whereNotIn('status', ['resolved', 'closed']);

        if ($request->classification) {
            $query->where('classification', $request->classification);
        }

        if ($request->severity) {
            $query->where('severity', $request->severity);
        }

        // Sort by SLA urgency (default)
        $complaints = $query->priorityQueue()->paginate(20)
            ->through(function ($complaint) {
                return [
                    'id' => $complaint->id,
                    'case_id' => $complaint->case_id,
                    'source' => $complaint->source,
                    'reporter_ref' => $complaint->reporter_ref,
                    'classification' => $complaint->classification,
                    'dispute_reason' => $complaint->dispute_reason,
                    'severity' => $complaint->severity,
                    'sla_remaining' => $complaint->sla_remaining,
                    'sla_deadline' => $complaint->sla_deadline,
                    'sla_breached' => $complaint->sla_breached,
                    'status' => $complaint->status,
                    'created_at' => $complaint->created_at->diffForHumans(),
                ];
            });

        return $this->success($complaints, 'priority_queue_fetched');
    }

    // ✅ 3. Manual Complaint Intake
    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|in:customer_app,provider_app,vendor_app,rider_app,support_agent,auto_generated',
            'reporter_type' => 'required|in:customer,provider,vendor,rider',
            'reporter_id' => 'required|integer',
            'related_entity_id' => 'nullable|string',
            'related_entity_type' => 'nullable|string',
            'dispute_reason' => 'required|string|min:10|max:2000',
            'initial_notes' => 'nullable|string|max:1000',
            'manual_classification' => 'nullable|in:service_quality,delivery_issues,payment_issues,fraud_allegations,behavior_misconduct,system_failure',
        ]);

        // ✅ Auto-classify
        $classified = $this->classifier->classify(
            $validated['dispute_reason'],
            $validated['source']
        );

        // ✅ Manual override if provided
        if ($validated['manual_classification'] ?? null) {
            $classified['classification'] = $validated['manual_classification'];
            $classified['classification_meta']['method'] = 'manual_override';
        }

        $complaint = Complaint::create([
            'case_id' => Complaint::generateCaseId(),
            'source' => $validated['source'],
            'reporter_type' => $validated['reporter_type'],
            'reporter_id' => $validated['reporter_id'],
            'reporter_ref' => strtoupper(substr($validated['reporter_type'], 0, 1))
                                   .'-'.$validated['reporter_id'],
            'related_entity_id' => $validated['related_entity_id'] ?? null,
            'related_entity_type' => $validated['related_entity_type'] ?? null,
            'classification' => $classified['classification'],
            'is_auto_classified' => ! isset($validated['manual_classification']),
            'dispute_reason' => $validated['dispute_reason'],
            'initial_notes' => $validated['initial_notes'] ?? null,
            'severity' => $classified['severity'],
            'sla_hours' => $classified['sla_hours'],
            'sla_deadline' => $classified['sla_deadline'],
            'status' => 'unassigned',
            'created_by' => auth()->id(),
            'classification_meta' => $classified['classification_meta'],
        ]);

        return $this->success(
            $complaint,
            'complaint_created',
            201
        );
    }

    // ✅ 4. Create Case from Queue
    public function createCase(Request $request, Complaint $complaint)
    {
        if ($complaint->status !== 'unassigned') {
            return $this->error('complaint_already_assigned', 422);
        }

        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $complaint->update([
            'status' => $request->assigned_to ? 'assigned' : 'unassigned',
            'assigned_to' => $request->assigned_to,
            'assigned_at' => $request->assigned_to ? now() : null,
        ]);

        return $this->success($complaint->fresh(), 'case_created');
    }

    // ✅ 5. Single Complaint Detail
    public function show(Complaint $complaint)
    {
        return $this->success(
            $complaint->load('assignedTo:id,name', 'createdBy:id,name'),
            'complaint_fetched'
        );
    }

    // ✅ 6. Update Classification
    public function reclassify(Request $request, Complaint $complaint)
    {
        $request->validate([
            'classification' => 'required|in:service_quality,delivery_issues,payment_issues,fraud_allegations,behavior_misconduct,system_failure',
            'severity' => 'required|in:low,medium,high,critical',
            'reason' => 'required|string|max:500',
        ]);

        // ✅ Recalculate SLA
        $slaConfig = SlaConfig::where('severity', $request->severity)->first();
        $slaHours = $slaConfig?->resolution_hours ?? 24;

        $complaint->update([
            'classification' => $request->classification,
            'severity' => $request->severity,
            'sla_hours' => $slaHours,
            'sla_deadline' => now()->addHours($slaHours),
            'is_auto_classified' => false,
            'classification_meta' => array_merge(
                $complaint->classification_meta ?? [],
                [
                    'reclassified_by' => auth()->id(),
                    'reclassification_reason' => $request->reason,
                    'reclassified_at' => now()->toDateTimeString(),
                ]
            ),
        ]);

        return $this->success($complaint->fresh(), 'complaint_reclassified');
    }

    // ✅ 7. Get Classification Rules
    public function getClassificationRules()
    {
        $rules = ClassificationRule::active()->get();

        return $this->success($rules, 'classification_rules_fetched');
    }

    // ✅ 8. Get SLA Configs
    public function getSlaConfigs()
    {
        $configs = SlaConfig::all();

        return $this->success($configs, 'sla_configs_fetched');
    }

    // ✅ 9. Update SLA Config
    public function updateSlaConfig(Request $request, SlaConfig $slaConfig)
    {
        $data = $request->validate([
            'response_hours' => 'required|integer|min:1',
            'resolution_hours' => 'required|integer|min:1',
            'auto_escalate' => 'required|boolean',
            'escalate_after_hours' => 'required|integer|min:1',
        ]);

        $slaConfig->update($data);

        return $this->success($slaConfig, 'sla_config_updated');
    }

    // ✅ 10. Export
    public function export()
    {
        $complaints = Complaint::latest()->get();
        $filename = 'complaints_'.now()->format('Y_m_d_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($complaints) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Case ID', 'Source', 'Reporter', 'Classification',
                'Dispute Reason', 'Severity', 'SLA Hours',
                'SLA Deadline', 'Status', 'Created At',
            ]);
            foreach ($complaints as $c) {
                fputcsv($file, [
                    $c->case_id, $c->source, $c->reporter_ref,
                    $c->classification, $c->dispute_reason,
                    $c->severity, $c->sla_hours,
                    $c->sla_deadline?->format('Y-m-d H:i:s'),
                    $c->status, $c->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}

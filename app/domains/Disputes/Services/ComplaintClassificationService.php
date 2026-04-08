<?php

namespace App\Domains\Disputes\Services;

use App\Domains\Disputes\Models\ClassificationRule;
use App\Domains\Disputes\Models\Complaint;
use App\Domains\Disputes\Models\SlaConfig;
use Illuminate\Support\Facades\Log;

class ComplaintClassificationService
{
    // ═══════════════════════════════════════
    // MAIN: Auto Classify Complaint
    // ═══════════════════════════════════════

    public function classify(string $disputeReason, string $source): array
    {
        // ✅ Step 1: Get all active rules (ordered by priority)
        $rules = ClassificationRule::active()->get();

        $text = strtolower($disputeReason);
        $classification = 'service_quality'; // default
        $severity = 'medium';          // default
        $slaHours = 24;                // default
        $confidence = 0;
        $matchedRule = null;

        // ✅ Step 2: Keyword matching
        foreach ($rules as $rule) {
            foreach ($rule->keywords as $keyword) {
                if (str_contains($text, strtolower($keyword))) {
                    $classification = $rule->classification;
                    $severity = $rule->severity;
                    $slaHours = $rule->sla_hours;
                    $confidence = 85 + ($rule->priority * 2);
                    $matchedRule = $rule->rule_key;
                    break 2; // Found match - stop searching
                }
            }
        }

        // ✅ Step 3: Source-based override
        if ($source === 'auto_generated') {
            // System generated = always high priority
            $severity = $severity === 'low' ? 'high' : $severity;
            $slaHours = min($slaHours, 2);
        }

        // ✅ Step 4: Calculate SLA deadline
        $slaConfig = SlaConfig::where('severity', $severity)->first();
        $finalHours = $slaConfig?->resolution_hours ?? $slaHours;
        $slaDeadline = now()->addHours($finalHours);

        Log::info('📋 Complaint classified', [
            'classification' => $classification,
            'severity' => $severity,
            'sla_hours' => $finalHours,
            'confidence' => $confidence,
            'matched_rule' => $matchedRule,
        ]);

        return [
            'classification' => $classification,
            'severity' => $severity,
            'sla_hours' => $finalHours,
            'sla_deadline' => $slaDeadline,
            'classification_meta' => [
                'confidence' => min(100, $confidence),
                'matched_rule' => $matchedRule,
                'method' => 'rule_based',
            ],
        ];
    }

    // ✅ Check SLA breaches
    public function checkSlaBreaches(): int
    {
        $breached = Complaint::whereNotIn('status', ['resolved', 'closed'])
            ->where('sla_deadline', '<', now())
            ->where('sla_breached', false)
            ->get();

        foreach ($breached as $complaint) {
            $complaint->update([
                'sla_breached' => true,
                'status' => 'escalated',
            ]);

            Log::warning("⚠️ SLA breached: {$complaint->case_id}");
        }

        return $breached->count();
    }

    // ✅ Dashboard stats
    public function getDashboardStats(): array
    {
        return [
            'sla_breaching_soon' => Complaint::slaBreachingSoon()->count(),
            'unassigned_intake' => Complaint::unassigned()->count(),
            'by_severity' => [
                'critical' => Complaint::where('severity', 'critical')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'high' => Complaint::where('severity', 'high')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'medium' => Complaint::where('severity', 'medium')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'low' => Complaint::where('severity', 'low')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
            ],
            'by_classification' => [
                'fraud_allegations' => Complaint::where('classification', 'fraud_allegations')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'delivery_issues' => Complaint::where('classification', 'delivery_issues')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'payment_issues' => Complaint::where('classification', 'payment_issues')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
                'behavior_misconduct' => Complaint::where('classification', 'behavior_misconduct')
                    ->whereNotIn('status', ['resolved', 'closed'])->count(),
            ],
            'total_active' => Complaint::whereNotIn('status', ['resolved', 'closed'])->count(),
        ];
    }
}

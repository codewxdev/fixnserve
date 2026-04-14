<?php

namespace Database\Seeders;

use App\Domains\Disputes\Models\EscalationRule;
use App\Domains\Disputes\Models\SlaLevelConfig;
use Illuminate\Database\Seeder;

class SlaEscalationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ SLA Level Configs
        $levels = [
            [
                'level' => 'standard',
                'label' => 'Standard',
                'first_response_hours' => 4,
                'resolution_hours' => 48,
                'approaching_alert_hours' => 4,
                'requires_supervisor' => false,
                'requires_legal_review' => false,
            ],
            [
                'level' => 'priority',
                'label' => 'Priority',
                'first_response_hours' => 1,
                'resolution_hours' => 8,
                'approaching_alert_hours' => 1,
                'requires_supervisor' => true,
                'requires_legal_review' => false,
            ],
            [
                'level' => 'legal',
                'label' => 'Legal Escalation',
                'first_response_hours' => 0,
                'resolution_hours' => 2,
                'approaching_alert_hours' => 0,
                'requires_supervisor' => true,
                'requires_legal_review' => true,
            ],
        ];

        foreach ($levels as $level) {
            SlaLevelConfig::updateOrCreate(
                ['level' => $level['level']],
                $level
            );
        }

        // ✅ Escalation Rules
        $rules = [
            [
                'rule_key' => 'support_to_senior',
                'from_role' => 'support_agent',
                'to_role' => 'senior_ops',
                'trigger_after_hours' => 2,
                'trigger_on' => 'breach',
                'auto_escalate' => true,
                'notify_supervisor' => true,
            ],
            [
                'rule_key' => 'senior_to_finance',
                'from_role' => 'senior_ops',
                'to_role' => 'finance',
                'trigger_after_hours' => 4,
                'trigger_on' => 'breach',
                'auto_escalate' => true,
                'notify_supervisor' => true,
            ],
            [
                'rule_key' => 'finance_to_legal',
                'from_role' => 'finance',
                'to_role' => 'legal',
                'trigger_after_hours' => 8,
                'trigger_on' => 'breach',
                'auto_escalate' => true,
                'notify_supervisor' => true,
            ],
        ];

        foreach ($rules as $rule) {
            EscalationRule::updateOrCreate(
                ['rule_key' => $rule['rule_key']],
                $rule
            );
        }
    }
}

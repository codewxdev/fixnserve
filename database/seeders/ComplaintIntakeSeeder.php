<?php

namespace Database\Seeders;

use App\Domains\Disputes\Models\ClassificationRule;
use App\Domains\Disputes\Models\SlaConfig;
use Illuminate\Database\Seeder;

class ComplaintIntakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Classification Rules
        $rules = [
            [
                'rule_key' => 'fraud_unrecognized_charge',
                'classification' => 'fraud_allegations',
                'keywords' => ['unrecognized charge', 'fraud', 'unauthorized', 'scam', 'chargeback'],
                'severity' => 'critical',
                'sla_hours' => 1,
                'priority' => 100,
            ],
            [
                'rule_key' => 'delivery_not_received',
                'classification' => 'delivery_issues',
                'keywords' => ['not received', 'not delivered', 'missing order', 'wrong item', 'late delivery'],
                'severity' => 'high',
                'sla_hours' => 2,
                'priority' => 80,
            ],
            [
                'rule_key' => 'payment_failed',
                'classification' => 'payment_issues',
                'keywords' => ['payment failed', 'deducted', 'refund', 'double charge', 'not refunded'],
                'severity' => 'high',
                'sla_hours' => 4,
                'priority' => 80,
            ],
            [
                'rule_key' => 'behavior_misconduct',
                'classification' => 'behavior_misconduct',
                'keywords' => ['rude', 'misconduct', 'refused', 'harassment', 'unprofessional'],
                'severity' => 'medium',
                'sla_hours' => 24,
                'priority' => 60,
            ],
            [
                'rule_key' => 'system_failure',
                'classification' => 'system_failure',
                'keywords' => ['app crash', 'not working', 'error', 'bug', 'system down'],
                'severity' => 'medium',
                'sla_hours' => 8,
                'priority' => 50,
            ],
            [
                'rule_key' => 'service_quality',
                'classification' => 'service_quality',
                'keywords' => ['bad service', 'poor quality', 'not satisfied', 'complaint'],
                'severity' => 'low',
                'sla_hours' => 48,
                'priority' => 10,
            ],
        ];

        foreach ($rules as $rule) {
            ClassificationRule::updateOrCreate(
                ['rule_key' => $rule['rule_key']],
                $rule
            );
        }

        // ✅ SLA Configs
        $slaConfigs = [
            [
                'severity' => 'critical',
                'response_hours' => 0,    // immediate
                'resolution_hours' => 1,    // 30 mins - 1 hour
                'auto_escalate' => true,
                'escalate_after_hours' => 1,
            ],
            [
                'severity' => 'high',
                'response_hours' => 1,
                'resolution_hours' => 4,
                'auto_escalate' => true,
                'escalate_after_hours' => 2,
            ],
            [
                'severity' => 'medium',
                'response_hours' => 4,
                'resolution_hours' => 24,
                'auto_escalate' => true,
                'escalate_after_hours' => 12,
            ],
            [
                'severity' => 'low',
                'response_hours' => 24,
                'resolution_hours' => 72,
                'auto_escalate' => false,
                'escalate_after_hours' => 48,
            ],
        ];

        foreach ($slaConfigs as $config) {
            SlaConfig::updateOrCreate(
                ['severity' => $config['severity']],
                $config
            );
        }
    }
}

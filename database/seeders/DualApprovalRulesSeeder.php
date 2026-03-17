<?php

namespace Database\Seeders;

use App\Domains\System\Models\DualApprovalRule;
use Illuminate\Database\Seeder;

class DualApprovalRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'setting_key' => 'financial_settings',
                'setting_label' => 'Financial Settings',
                'description' => 'Pricing models, surge rules, payment gateways',
                'requires_approval' => true,
            ],
            [
                'setting_key' => 'api_rate_limits',
                'setting_label' => 'API Rate Limits & Throttling',
                'description' => 'Global rate limits, emergency throttling',
                'requires_approval' => true,
            ],
            [
                'setting_key' => 'geofence_outages',
                'setting_label' => 'Geofence Outages',
                'description' => 'Creating restricted zones, emergency locks',
                'requires_approval' => false,
            ],
        ];

        foreach ($rules as $rule) {
            DualApprovalRule::updateOrCreate(
                ['setting_key' => $rule['setting_key']],
                $rule
            );
        }
    }
}

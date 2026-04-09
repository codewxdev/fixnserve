<?php

namespace Database\Seeders;

use App\Domains\Disputes\Models\AppealPolicy;
use Illuminate\Database\Seeder;

class AppealPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AppealPolicy::updateOrCreate(
            ['policy_key' => 'default'],
            [
                'max_appeals_per_user' => 3,    // 3 per month
                'appeal_window_days' => 7,    // 7 days to appeal
                'cooldown_hours' => 24,   // 24h between appeals
                'review_sla_hours' => 48,   // 48h to review
                'require_new_evidence' => false,
                'is_active' => true,
            ]
        );
    }
}

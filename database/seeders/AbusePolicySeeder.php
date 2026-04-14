<?php

namespace Database\Seeders;

use App\Domains\Disputes\Models\AbusePolicy;
use Illuminate\Database\Seeder;

class AbusePolicySeeder extends Seeder
{
    public function run(): void
    {
        AbusePolicy::updateOrCreate(
            ['policy_key' => 'default'],
            [
                'label' => 'Default Abuse Policy',
                'max_disputes_per_month' => 5,
                'max_refunds_per_month' => 3,
                'false_claim_threshold' => 3,
                'refund_amount_threshold' => 5000,
                'coordinated_complaint_threshold' => 5,
                'auto_enforce' => true,
                'is_active' => true,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use App\Domains\Disputes\Models\RefundPolicy;
use Illuminate\Database\Seeder;

class RefundPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefundPolicy::updateOrCreate(
            ['policy_key' => 'default'],
            [
                'label' => 'Default Refund Policy',
                'max_auto_approve_amount' => 1000,
                'finance_approval_threshold' => 5000,
                'max_refunds_per_month' => 3,
                'fraud_score_block_threshold' => 70,
                'completion_refund_matrix' => [
                    ['from' => 0,  'to' => 0,  'refund_percent' => 100],
                    ['from' => 1,  'to' => 25, 'refund_percent' => 75],
                    ['from' => 26, 'to' => 50, 'refund_percent' => 50],
                    ['from' => 51, 'to' => 75, 'refund_percent' => 25],
                    ['from' => 76, 'to' => 90, 'refund_percent' => 10],
                    ['from' => 91, 'to' => 100, 'refund_percent' => 0],
                ],
                'is_active' => true,
            ]
        );
    }
}

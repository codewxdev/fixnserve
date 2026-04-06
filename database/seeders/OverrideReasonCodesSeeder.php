<?php

namespace Database\Seeders;

use App\Domains\Fraud\Models\OverrideReasonCode;
use Illuminate\Database\Seeder;

class OverrideReasonCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [
            // Exception Codes
            [
                'code' => 'EXCP-01',
                'label' => 'System Error',
                'category' => 'exception',
                'requires_dual_approval' => false,
            ],
            [
                'code' => 'EXCP-04',
                'label' => 'False Positive',
                'category' => 'exception',
                'requires_dual_approval' => false,
            ],

            // Compliance Codes
            [
                'code' => 'COMP-01',
                'label' => 'Compliance Cleared',
                'category' => 'compliance',
                'requires_dual_approval' => true,
            ],
            [
                'code' => 'COMP-02',
                'label' => 'Legal Clearance',
                'category' => 'compliance',
                'requires_dual_approval' => true,
            ],

            // Operational Codes
            [
                'code' => 'OPER-01',
                'label' => 'Customer Verified',
                'category' => 'operational',
                'requires_dual_approval' => false,
            ],
            [
                'code' => 'OPER-02',
                'label' => 'Manual Review Complete',
                'category' => 'operational',
                'requires_dual_approval' => false,
            ],
        ];

        foreach ($codes as $code) {
            OverrideReasonCode::updateOrCreate(
                ['code' => $code['code']],
                $code
            );
        }
    }
}

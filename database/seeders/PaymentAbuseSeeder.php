<?php

namespace Database\Seeders;

use App\Domains\Fraud\Models\PaymentThreatPattern;
use App\Domains\Fraud\Models\PaymentVelocityLimit;
use Illuminate\Database\Seeder;

class PaymentAbuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Threat Patterns
        $patterns = [
            [
                'pattern_key' => 'refund_wallet_loop',
                'name' => 'Refund-Wallet Loops',
                'description' => 'Detects rapid order placement and immediate refund to wallet for cashing out.',
                'severity' => 'critical',
                'auto_action' => 'wallet_freeze',
                'detection_rules' => [
                    'cancelled_orders_threshold' => 3,
                    'time_window_minutes' => 60,
                ],
            ],
            [
                'pattern_key' => 'cod_manipulation',
                'name' => 'COD Manipulation',
                'description' => 'Rider marks COD collected but delays deposit, or customer rejects high-value COD repeatedly.',
                'severity' => 'high',
                'auto_action' => 'block_cod',
                'detection_rules' => [
                    'delay_threshold_hours' => 48,
                ],
            ],
            [
                'pattern_key' => 'chargeback_clustering',
                'name' => 'Chargeback Clustering',
                'description' => 'Multiple chargebacks originating from the same device or IP block.',
                'severity' => 'medium',
                'auto_action' => 'payout_delay',
                'detection_rules' => [
                    'chargeback_threshold' => 3,
                    'time_window_days' => 30,
                ],
            ],
        ];

        foreach ($patterns as $pattern) {
            PaymentThreatPattern::updateOrCreate(
                ['pattern_key' => $pattern['pattern_key']],
                $pattern
            );
        }

        // ✅ Velocity Limits
        $limits = [
            [
                'limit_key' => 'topups_per_day',
                'label' => 'Top-ups / 24h',
                'max_count' => 5,
                'window' => '24h',
            ],
            [
                'limit_key' => 'withdrawals_per_day',
                'label' => 'Withdrawals / 24h',
                'max_count' => 2,
                'window' => '24h',
            ],
        ];

        foreach ($limits as $limit) {
            PaymentVelocityLimit::updateOrCreate(
                ['limit_key' => $limit['limit_key']],
                $limit
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Domains\Fraud\Models\RiskSignalWeight;
use Illuminate\Database\Seeder;

class RiskSignalWeightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $signals = [
            [
                'signal_key' => 'device_reuse',
                'signal_label' => 'Device Reuse (Multi-acc)',
                'weight' => 80,
                'impact' => 'high',
            ],
            [
                'signal_key' => 'payment_failures',
                'signal_label' => 'Payment Failures',
                'weight' => 60,
                'impact' => 'medium',
            ],
            [
                'signal_key' => 'velocity_patterns',
                'signal_label' => 'Velocity Patterns (Wallet)',
                'weight' => 75,
                'impact' => 'high',
            ],
            [
                'signal_key' => 'geo_inconsistencies',
                'signal_label' => 'Geo Inconsistencies',
                'weight' => 40,
                'impact' => 'low',
            ],
            [
                'signal_key' => 'dispute_frequency',
                'signal_label' => 'Dispute Frequency',
                'weight' => 65,
                'impact' => 'medium',
            ],
        ];

        foreach ($signals as $signal) {
            RiskSignalWeight::updateOrCreate(
                ['signal_key' => $signal['signal_key']],
                $signal
            );
        }
    }
}

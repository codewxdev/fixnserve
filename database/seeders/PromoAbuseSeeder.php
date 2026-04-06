<?php

namespace Database\Seeders;

use App\Domains\Fraud\Models\PromoAbuseRule;
use Illuminate\Database\Seeder;

class PromoAbuseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'rule_key' => 'multiple_accounts_per_device',
                'label' => 'Multiple Accs per Device',
                'action' => 'block',
                'config' => ['max_accounts' => 1],
            ],
            [
                'rule_key' => 'promo_stacking_attempt',
                'label' => 'Promo Stacking Attempt',
                'action' => 'invalidate',
                'config' => ['exclusive_codes' => ['WELCOME50', 'FREE-DEL', 'NEWUSER']],
            ],
            [
                'rule_key' => 'new_user_promo_old_card',
                'label' => 'New User Promo (Old Card)',
                'action' => 'reject',
                'config' => ['check_card_history' => true],
            ],
        ];

        foreach ($rules as $rule) {
            PromoAbuseRule::updateOrCreate(
                ['rule_key' => $rule['rule_key']],
                $rule
            );
        }
    }
}

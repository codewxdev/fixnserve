<?php

namespace Database\Seeders;

use App\Domains\Security\Models\TokenPolicy;
use Illuminate\Database\Seeder;

class TokenPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TokenPolicy::create([

            'access_token_ttl_minutes' => 60,

            'refresh_token_ttl_days' => 30,

            'rotate_refresh_on_use' => true,

            'grace_period_seconds' => 30,

        ]);
    }
}

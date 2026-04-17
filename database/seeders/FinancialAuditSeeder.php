<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialAuditSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Sample commission rates config
        DB::table('commission_configs')->insertOrIgnore([
            ['entity_type' => 'vendor',   'rate' => 15.00, 'created_at' => now(), 'updated_at' => now()],
            ['entity_type' => 'provider', 'rate' => 20.00, 'created_at' => now(), 'updated_at' => now()],
            ['entity_type' => 'rider',    'rate' => 10.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

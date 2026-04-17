<?php

namespace Database\Seeders;

use App\Domains\Audit\Models\SecurityAuditLog;
use Illuminate\Database\Seeder;

class SecurityAuditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ✅ Sample audit log
        SecurityAuditLog::create([
            'log_id' => 'SAL-2026-000001',
            'user_id' => 1,
            'user_ref' => 'A-1',
            'user_role' => 'Super Admin',
            'event_type' => 'login_success',
            'ip_address' => '127.0.0.1',
            'device' => 'PostmanRuntime/7.51.1',
            'success' => true,
            'risk_score' => 0,
            'occurred_at' => now(),
            'checksum' => hash('sha256', '1_login_success_127.0.0.1_'.now()),
        ]);
    }
}

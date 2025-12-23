<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'System Notifications',

            ],
            [
                'name' => 'Marketing Emails',

            ],
            [
                'name' => 'Transaction Alerts',

            ],
            [
                'name' => 'Security Alerts',

            ],
            [
                'name' => 'Account Updates',

            ],
        ];

        foreach ($types as $type) {
            NotificationType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}

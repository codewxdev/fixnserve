<?php

namespace Database\Seeders;

use App\Models\App;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apps = [
            [
                'name' => 'Service Provider',
                'app_key' => 'service_provider',
            ],
            [
                'name' => 'Expert Professional',
                'app_key' => 'expert_professional',
            ],
            [
                'name' => 'Consultancy',
                'app_key' => 'consultancy',
            ],
            [
                'name' => 'Rider',
                'app_key' => 'rider',
            ],
            [
                'name' => 'Customer',
                'app_key' => 'customer',
            ],
        ];

        foreach ($apps as $app) {
            App::updateOrCreate(
                ['app_key' => $app['app_key']], // unique key
                $app
            );
        }
    }
}

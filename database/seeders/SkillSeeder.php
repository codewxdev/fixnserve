<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Plumbing
            'Plumbing Service',
            'Water Pipe Repair',
            'Bathroom Fittings',
            'Kitchen Sink Repair',
            'Drain Cleaning',
            'Water Tank Installation',
            'Leakage Fixing',
            'Tap / Mixer Repair',

            // Electrical
            'Electric Wiring',
            'Switch Board Repair',
            'Fan Installation',
            'Light Installation',
            'Circuit Breaker Repair',
            'Inverter Setup',
            'Generator Wiring',
            'Doorbell Installation',

            // AC / Refrigeration
            'AC Service',
            'AC Gas Charging',
            'AC Installation',
            'AC Repair',
            'Refrigerator Repair',
            'Deep Freezer Repair',
            'Water Dispenser Repair',

            // Carpenter
            'Furniture Repair',
            'Door Lock Fixing',
            'Bed Assembly',
            'Wood Polishing',
            'Kitchen Cabinet Repair',
            'Window Frame Repair',

            // Painter
            'Wall Painting',
            'Ceiling Painting',
            'Wallpaper Installation',
            'Exterior Painting',
            'Waterproofing',

            // Home Cleaning
            'Home Deep Cleaning',
            'Bathroom Cleaning',
            'Kitchen Cleaning',
            'Sofa Cleaning',
            'Carpet Shampooing',
            'Glass Cleaning',

            // Appliance Repair
            'Washing Machine Repair',
            'Microwave Repair',
            'LED TV Repair',
            'Gas Stove Repair',
            'Water Heater Repair',

            // Misc
            'Pest Control',
            'CCTV Installation',
            'UPS Repair',
            'Solar Panel Cleaning',
        ];

        foreach ($skills as $skill) {
            DB::table('skills')->insert([
                'name' => $skill,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

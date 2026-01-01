<?php

namespace Database\Seeders;

use App\Models\MartCategory;
use Illuminate\Database\Seeder;

class MartCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Grocery', 'description' => 'All grocery items', 'status' => 1],
            ['name' => 'Beverages', 'description' => 'Drinks, Tea, Coffee', 'status' => 1],
            ['name' => 'Personal Care', 'description' => 'Soaps, Shampoo, Skin care', 'status' => 1],
            ['name' => 'Household', 'description' => 'Cleaning & daily essentials', 'status' => 1],
            ['name' => 'Health & Wellness', 'description' => 'Medicines & supplements', 'status' => 1],
            ['name' => 'Pet Supplies', 'description' => 'Pet food & accessories', 'status' => 1],
        ];

        foreach ($categories as $cat) {
            MartCategory::create($cat);
        }
    }
}

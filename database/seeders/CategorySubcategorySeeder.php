<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Example categories with type
        $categories = [
            ['name' => 'Plumbing', 'type' => 'serviceProvider'],
            ['name' => 'Electrical', 'type' => 'serviceProvider'],
            ['name' => 'AC & Heating', 'type' => 'serviceProvider'],
            ['name' => 'Carpentry', 'type' => 'serviceProvider'],
            ['name' => 'Cleaning', 'type' => 'serviceProvider'],
            ['name' => 'Painting', 'type' => 'serviceProvider'],
            ['name' => 'Gardening', 'type' => 'serviceProvider'],
            ['name' => 'Pest Control', 'type' => 'serviceProvider'],
            ['name' => 'Roofing', 'type' => 'serviceProvider'],
            ['name' => 'Appliance Repair', 'type' => 'serviceProvider'],
        ];

        foreach ($categories as $catData) {
            $category = Category::create([
                'name' => $catData['name'],
                'type' => $catData['type'],
            ]);

            // 5 subcategories for each
            for ($i = 1; $i <= 5; $i++) {
                Subcategory::create([
                    'name' => $catData['name'].' Sub '.$i,
                    'category_id' => $category->id,
                ]);
            }
        }

        $this->command->info('Categories & Subcategories seeded successfully with type!');
    }
}

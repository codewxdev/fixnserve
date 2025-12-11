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
        // Example categories
        $categories = [
            'Plumbing',
            'Electrical',
            'AC & Heating',
            'Carpentry',
            'Cleaning',
            'Painting',
            'Gardening',
            'Pest Control',
            'Roofing',
            'Appliance Repair',
        ];

        foreach ($categories as $catName) {
            $category = Category::create(['name' => $catName]);

            // 5 subcategories for each
            for ($i = 1; $i <= 5; $i++) {
                Subcategory::create([
                    'name' => $catName.' Sub '.$i,
                    'category_id' => $category->id,
                ]);
            }
        }

        $this->command->info('Categories & Subcategories seeded successfully!');
    }
}

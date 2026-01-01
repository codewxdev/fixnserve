<?php

namespace Database\Seeders;

use App\Models\MartCategory;
use App\Models\MartSubCategory;
use Illuminate\Database\Seeder;

class MartSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            'Grocery' => [
                'Fruits & Vegetables',
                'Rice & Grains',
                'Spices & Masalas',
                'Cooking Oil & Ghee',
                'Snacks & Namkeen',
            ],
            'Beverages' => [
                'Tea & Coffee',
                'Juices',
                'Soft Drinks',
                'Energy Drinks',
                'Milk & Dairy Products',
            ],
            'Personal Care' => [
                'Soaps & Body Wash',
                'Shampoo & Conditioners',
                'Toothpaste & Oral Care',
                'Skin Care',
                'Hair Care',
            ],
            'Household' => [
                'Detergents',
                'Dishwashing Items',
                'Floor & Surface Cleaners',
                'Air Fresheners',
                'Tissue & Paper Towels',
            ],
            'Health & Wellness' => [
                'Medicines (OTC)',
                'Vitamins & Supplements',
                'First Aid',
                'Medical Devices',
            ],
            'Pet Supplies' => [
                'Pet Food',
                'Pet Hygiene',
                'Pet Accessories',
            ],
        ];

        foreach ($subCategories as $categoryName => $subs) {
            $category = MartCategory::where('name', $categoryName)->first();
            if ($category) {
                foreach ($subs as $sub) {
                    MartSubCategory::create([
                        'mart_category_id' => $category->id,
                        'name' => $sub,
                        'status' => 1,
                    ]);
                }
            }
        }
    }
}

<?php

namespace App\Services;

use App\Domains\Catalog\Admin\Models\Category;
use App\Domains\Catalog\Admin\Models\Subcategory;

class HierarchyService
{
    public function createCategory(array $data)
    {
        return Category::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);
    }

    public function createSubcategory(array $data)
    {
        return Subcategory::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
        ]);
    }
}
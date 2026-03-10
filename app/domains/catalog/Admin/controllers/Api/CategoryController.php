<?php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\Category;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    public function index()
    {
        $categories = Category::all();

        return $this->success(
            $categories,
            'categories_fetched'
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:serviceProvider,professionalExpert,onlineConsultant,martVender',
        ]);

        $category = Category::create($validated);

        return $this->success(
            $category,
            'category_created',
            201
        );
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return $this->success(
            $category,
            'category_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:serviceProvider,professionalExpert,onlineConsultant,martVender',
        ]);

        $category->update($validated);

        return $this->success(
            $category,
            'category_updated'
        );
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return $this->success(
            null,
            'category_deleted'
        );
    }
}

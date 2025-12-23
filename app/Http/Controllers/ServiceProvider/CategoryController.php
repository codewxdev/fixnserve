<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return ApiResponse::success($categories, 'Categories fetched successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return ApiResponse::success($category, 'Category created successfully', 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return ApiResponse::success($category, 'Category fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return ApiResponse::success($category, 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return ApiResponse::success(null, 'Category deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();

        return ApiResponse::success($subcategories, 'Subcategories fetched successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $sub = Subcategory::create($request->only(['category_id', 'name']));

        return ApiResponse::success($sub, 'Subcategory created successfully', 201);
    }

    public function show($id)
    {
        $sub = Subcategory::findOrFail($id);

        return ApiResponse::success($sub, 'Subcategory fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $sub = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'nullable|string|max:255',
        ]);

        $sub->update($request->only(['category_id', 'name']));

        return ApiResponse::success($sub, 'Subcategory updated successfully');
    }

    public function destroy($id)
    {
        $deleted = Subcategory::destroy($id);

        if ($deleted) {
            return ApiResponse::success(null, 'Subcategory deleted successfully');
        }

        return ApiResponse::error('Subcategory not found', 404);
    }
}

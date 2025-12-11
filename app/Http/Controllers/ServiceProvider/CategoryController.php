<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Category::all(),
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $category,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $category->update($request->name);

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category,
        ], 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }
}

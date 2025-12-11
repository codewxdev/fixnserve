<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $sub = Subcategory::with('category')->get();

        return response()->json($sub);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
        ]);

        $sub = Subcategory::create($request->all());

        return response()->json($sub);
    }

    public function show($id)
    {
        $sub = Subcategory::findOrFail($id);

        return response()->json($sub);
    }

    public function update(Request $request, $id)
    {
        $sub = Subcategory::findOrFail($id);

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'nullable|string|max:255',
        ]);

        $sub->update($request->only(['category_id', 'name']));

        return response()->json($sub, 200);
    }

    public function destroy($id)
    {
        Subcategory::destroy($id);

        return response()->json(['message' => 'Deleted']);
    }
}

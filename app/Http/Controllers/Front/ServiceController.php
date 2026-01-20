<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Models\Category;
use App\Models\Specialty;
use App\Models\Subcategory;
use App\Models\SubSpecialty;
use App\Services\HierarchyService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{

    protected $hierarchyService;

    public function __construct(HierarchyService $hierarchyService)
    {
        $this->hierarchyService = $hierarchyService;
    }

    public function storeCategory(StoreCategoryRequest $request): JsonResponse
    {

        $category = $this->hierarchyService->createCategory($request->validated());
        return response()->json(['message' => 'Category created successfully', 'data' => $category]);
    }

    public function storeSubcategory(StoreSubcategoryRequest $request): JsonResponse
    {
        $subcategory = $this->hierarchyService->createSubcategory($request->validated());
        return response()->json(['message' => 'Subcategory created successfully', 'data' => $subcategory]);
    }


    public function storeSpecialty(Request $request)
    {
        $request->validate(['name' => 'required', 'subcategory_id' => 'required|exists:subcategories,id']);
        Specialty::create($request->all());
        return response()->json(['message' => 'Specialty added successfully']);
    }

    public function storeSubSpecialty(Request $request)
    {
        $request->validate(['name' => 'required', 'specialty_id' => 'required|exists:specialties,id']);
        SubSpecialty::create($request->all());
        return response()->json(['message' => 'Sub-Specialty added successfully']);
    }

    // Update Main Category
    // --- Dynamic Update Methods ---
    public function updateCategory(Request $request, $id)
    {
        $item = Category::findOrFail($id);
        $item->update($request->only('name', 'active'));
        return response()->json(['message' => 'Updated']);
    }

    public function updateSubcategory(Request $request, $id)
    {
        $item = Subcategory::findOrFail($id);
        $item->update($request->only('name', 'active'));
        return response()->json(['message' => 'Updated']);
    }

    public function updateSpecialty(Request $request, $id)
    {
        $item = Specialty::findOrFail($id);
        $item->update($request->only('name', 'active'));
        return response()->json(['message' => 'Updated']);
    }

    public function updateSubSpecialty(Request $request, $id)
    {
        $item = SubSpecialty::findOrFail($id);
        $item->update($request->only('name', 'active'));
        return response()->json(['message' => 'Updated']);
    }

    // --- Dynamic Toggle Status Methods (PATCH) ---
    public function toggleCategoryStatus(Request $request, $id)
    {
        Category::where('id', $id)->update(['active' => $request->active]);
        return response()->json(['status' => 'success']);
    }

    public function toggleSubcategoryStatus(Request $request, $id)
    {
        Subcategory::where('id', $id)->update(['active' => $request->active]);
        return response()->json(['status' => 'success']);
    }

    public function toggleSpecialtyStatus(Request $request, $id)
    {
        Specialty::where('id', $id)->update(['active' => $request->active]);
        return response()->json(['status' => 'success']);
    }

    public function toggleSubSpecialtyStatus(Request $request, $id)
    {
        SubSpecialty::where('id', $id)->update(['active' => $request->active]);
        return response()->json(['status' => 'success']);
    }
    // Delete Main Category
    public function destroyCategory($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'Category and its children deleted']);
    }

    // Delete Subcategory
    public function destroySubcategory($id)
    {
        Subcategory::findOrFail($id)->delete();
        return response()->json(['message' => 'Subcategory and its specialties deleted']);
    }

    // Delete Specialty
    public function destroySpecialty($id)
    {
        Specialty::findOrFail($id)->delete();
        return response()->json(['message' => 'Specialty and its sub-specialties deleted']);
    }

    // Delete SubSpecialty
    public function destroySubSpecialty($id)
    {
        SubSpecialty::findOrFail($id)->delete();
        return response()->json(['message' => 'Sub-Specialty deleted']);
    }

    public function index()
    {
        $categories = Category::with('subcategories.specialties.sub_specialties')->get();
        return view('Admin.Service.index', compact('categories'));
    }
}

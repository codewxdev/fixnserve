<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Models\Category;
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

    public function index(){

        $categories = Category::with('subcategories')->get();
        return view('Admin.Service.index',compact('categories'));

    }
}

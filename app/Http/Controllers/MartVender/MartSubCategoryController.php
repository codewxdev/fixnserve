<?php

namespace App\Http\Controllers\MartVender;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\MartSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MartSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = MartSubCategory::with('category')->latest()->get();

        return ApiResponse::success($subCategories, 'Subcategories fetched successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mart_category_id' => 'required|exists:mart_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $subCategory = MartSubCategory::create($request->only([
            'mart_category_id',
            'name',
            'description',
            'status',
        ]));

        return ApiResponse::success($subCategory, 'Subcategory created successfully', 201);
    }

    public function show($id)
    {
        $subCategory = MartSubCategory::with('category')->find($id);
        if (! $subCategory) {
            return ApiResponse::notFound('Subcategory not found');
        }

        return ApiResponse::success($subCategory, 'Subcategory fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $subCategory = MartSubCategory::find($id);
        if (! $subCategory) {
            return ApiResponse::notFound('Subcategory not found');
        }

        $validator = Validator::make($request->all(), [
            'mart_category_id' => 'required|exists:mart_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $subCategory->update($request->only([
            'mart_category_id',
            'name',
            'description',
            'status',
        ]));

        return ApiResponse::success($subCategory, 'Subcategory updated successfully');
    }

    public function destroy($id)
    {
        $subCategory = MartSubCategory::find($id);
        if (! $subCategory) {
            return ApiResponse::notFound('Subcategory not found');
        }

        $subCategory->delete();

        return ApiResponse::success(null, 'Subcategory deleted successfully');
    }
}

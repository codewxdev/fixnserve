<?php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\MartCategory;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MartCategoryController extends Controller
{
    public function index()
    {
        $categories = MartCategory::latest()->get();

        return ApiResponse::success(
            $categories,
            'Mart categories fetched successfully'
        );
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $category = MartCategory::create($request->only([
            'name',
            'description',
            'status',
        ]));

        return ApiResponse::success(
            $category,
            'Category created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return ApiResponse::notFound('Mart category not found');
        }

        return ApiResponse::success(
            $category,
            'Category fetched successfully'
        );
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return ApiResponse::notFound('Mart category not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $category->update($request->only([
            'name',
            'description',
            'status',
        ]));

        return ApiResponse::success(
            $category,
            'Category updated successfully'
        );
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return ApiResponse::notFound('Mart category not found');
        }

        $category->delete();

        return ApiResponse::success(
            null,
            'Category deleted successfully'
        );
    }
}

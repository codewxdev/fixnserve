<?php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\MartSubCategory;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MartSubCategoryController extends BaseApiController
{
    public function index()
    {
        $subCategories = MartSubCategory::with('category')->latest()->get();

        return $this->success(
            $subCategories,
            'mart_subcategories_fetched'
        );
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
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $subCategory = MartSubCategory::create($request->only([
            'mart_category_id',
            'name',
            'description',
            'status',
        ]));

        return $this->success(
            $subCategory,
            'mart_subcategory_created',
            201
        );
    }

    public function show($id)
    {
        $subCategory = MartSubCategory::with('category')->find($id);

        if (! $subCategory) {
            return $this->error(
                'mart_subcategory_not_found',
                404
            );
        }

        return $this->success(
            $subCategory,
            'mart_subcategory_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $subCategory = MartSubCategory::find($id);

        if (! $subCategory) {
            return $this->error(
                'mart_subcategory_not_found',
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'mart_category_id' => 'required|exists:mart_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $subCategory->update($request->only([
            'mart_category_id',
            'name',
            'description',
            'status',
        ]));

        return $this->success(
            $subCategory,
            'mart_subcategory_updated'
        );
    }

    public function destroy($id)
    {
        $subCategory = MartSubCategory::find($id);

        if (! $subCategory) {
            return $this->error(
                'mart_subcategory_not_found',
                404
            );
        }

        $subCategory->delete();

        return $this->success(
            null,
            'mart_subcategory_deleted'
        );
    }
}

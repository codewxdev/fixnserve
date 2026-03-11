<?php

namespace App\Domains\Catalog\Controllers\Api;

use App\Domains\Catalog\Models\MartCategory;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MartCategoryController extends BaseApiController
{
    public function index()
    {
        $categories = MartCategory::latest()->get();

        return $this->success(
            $categories,
            'mart_categories_fetched'
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $category = MartCategory::create($request->only([
            'name',
            'description',
            'status',
        ]));

        return $this->success(
            $category,
            'mart_category_created',
            201
        );
    }

    public function show($id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return $this->error(
                'mart_category_not_found',
                404
            );
        }

        return $this->success(
            $category,
            'mart_category_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return $this->error(
                'mart_category_not_found',
                404
            );
        }

        $validator = Validator::make($request->all(), [
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

        $category->update($request->only([
            'name',
            'description',
            'status',
        ]));

        return $this->success(
            $category,
            'mart_category_updated'
        );
    }

    public function destroy($id)
    {
        $category = MartCategory::find($id);

        if (! $category) {
            return $this->error(
                'mart_category_not_found',
                404
            );
        }

        $category->delete();

        return $this->success(
            null,
            'mart_category_deleted'
        );
    }
}

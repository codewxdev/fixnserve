<?php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\Subcategory;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class SubcategoryController extends BaseApiController
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();

        return $this->success(
            $subcategories,
            'subcategories_fetched'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
        ]);

        $sub = Subcategory::create(
            $request->only(['category_id', 'name'])
        );

        return $this->success(
            $sub,
            'subcategory_created',
            201
        );
    }

    public function show($id)
    {
        $sub = Subcategory::find($id);

        if (! $sub) {
            return $this->error(
                'subcategory_not_found',
                404
            );
        }

        return $this->success(
            $sub,
            'subcategory_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $sub = Subcategory::find($id);

        if (! $sub) {
            return $this->error(
                'subcategory_not_found',
                404
            );
        }

        $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'nullable|string|max:255',
        ]);

        $sub->update(
            $request->only(['category_id', 'name'])
        );

        return $this->success(
            $sub,
            'subcategory_updated'
        );
    }

    public function destroy($id)
    {
        $sub = Subcategory::find($id);

        if (! $sub) {
            return $this->error(
                'subcategory_not_found',
                404
            );
        }

        $sub->delete();

        return $this->success(
            null,
            'subcategory_deleted'
        );
    }
}

<?php

namespace App\Http\Controllers\MartVender;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel; // make sure Auth is imported

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory'])->latest()->get();

        return ApiResponse::success($products, 'Products fetched successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku_no' => 'required|string|max:255|unique:products,sku_no',
            'category_id' => 'required|exists:mart_categories,id',
            'sub_category_id' => 'required|exists:mart_sub_categories,id',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $data = $request->only(['name', 'sku_no', 'category_id', 'sub_category_id', 'quantity', 'description', 'price']);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Add the logged-in user's id
        $data['user_id'] = Auth::id();

        $product = Product::create($data);

        return ApiResponse::success($product, 'Product created successfully', 201);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'subCategory'])->find($id);
        if (! $product) {
            return ApiResponse::notFound('Product not found');
        }

        return ApiResponse::success($product, 'Product fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (! $product) {
            return ApiResponse::notFound('Product not found');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku_no' => 'required|string|max:255|unique:products,sku_no,'.$product->id,
            'category_id' => 'required|exists:mart_categories,id',
            'sub_category_id' => 'required|exists:mart_sub_categories,id',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $data = $request->only(['name', 'sku_no', 'category_id', 'sub_category_id', 'quantity', 'description', 'price']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // Update the logged-in user's id
        $data['user_id'] = Auth::id();

        $product->update($data);

        return ApiResponse::success($product, 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (! $product) {
            return ApiResponse::notFound('Product not found');
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return ApiResponse::success(null, 'Product deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx,xls',
        ]);

        // Pass the logged-in user's ID to the import class
        Excel::import(new ProductsImport(Auth::id()), $request->file('file'));

        return ApiResponse::success(true, 'Products imported successfully');
    }
}

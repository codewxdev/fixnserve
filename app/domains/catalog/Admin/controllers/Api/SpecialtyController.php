<?php

// app/Http/Controllers/Api/SpecialtyController.php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\Specialty;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::with('subCategory')->get();

        return ApiResponse::success($specialties, 'Specialties fetched successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $specialty = Specialty::create([
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
        ]);

        return ApiResponse::success(
            $specialty->load('subCategory'),
            'Specialty created successfully',
            201
        );
    }

    public function show($id)
    {
        $specialty = Specialty::with('subCategory')->find($id);

        if (! $specialty) {
            return ApiResponse::notFound('Specialty not found');
        }

        return ApiResponse::success($specialty);
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::find($id);

        if (! $specialty) {
            return ApiResponse::notFound('Specialty not found');
        }

        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $specialty->update([
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
        ]);

        return ApiResponse::success(
            $specialty->load('subCategory'),
            'Specialty updated successfully'
        );
    }

    public function destroy($id)
    {
        $specialty = Specialty::find($id);

        if (! $specialty) {
            return ApiResponse::notFound('Specialty not found');
        }

        $specialty->delete();

        return ApiResponse::success(null, 'Specialty deleted successfully');
    }
}

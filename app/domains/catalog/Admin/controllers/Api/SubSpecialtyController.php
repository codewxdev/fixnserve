<?php

// app/Http/Controllers/Api/SubSpecialtyController.php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\SubSpecialty;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubSpecialtyController extends Controller
{
    public function index()
    {
        $subSpecialties = SubSpecialty::with('specialty')->get();

        return ApiResponse::success($subSpecialties, 'Sub specialties fetched successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $subSpecialty = SubSpecialty::create([
            'specialty_id' => $request->specialty_id,
            'name' => $request->name,
        ]);

        return ApiResponse::success(
            $subSpecialty->load('specialty'),
            'Sub specialty created successfully',
            201
        );
    }

    public function show($id)
    {
        $subSpecialty = SubSpecialty::with('specialty')->find($id);

        if (! $subSpecialty) {
            return ApiResponse::notFound('Sub specialty not found');
        }

        return ApiResponse::success($subSpecialty);
    }

    public function update(Request $request, $id)
    {
        $subSpecialty = SubSpecialty::find($id);

        if (! $subSpecialty) {
            return ApiResponse::notFound('Sub specialty not found');
        }

        $validator = Validator::make($request->all(), [
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors()->toArray());
        }

        $subSpecialty->update([
            'specialty_id' => $request->specialty_id,
            'name' => $request->name,
        ]);

        return ApiResponse::success(
            $subSpecialty->load('specialty'),
            'Sub specialty updated successfully'
        );
    }

    public function destroy($id)
    {
        $subSpecialty = SubSpecialty::find($id);

        if (! $subSpecialty) {
            return ApiResponse::notFound('Sub specialty not found');
        }

        $subSpecialty->delete();

        return ApiResponse::success(null, 'Sub specialty deleted successfully');
    }
}

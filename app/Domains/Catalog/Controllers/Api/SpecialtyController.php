<?php

namespace App\Domains\Catalog\Controllers\Api;

use App\Domains\Catalog\Models\Specialty;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends BaseApiController
{
    public function index()
    {
        $specialties = Specialty::with('subCategory')->get();

        return $this->success(
            $specialties,
            'specialties_fetched'
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $specialty = Specialty::create([
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
        ]);

        return $this->success(
            $specialty->load('subCategory'),
            'specialty_created',
            201
        );
    }

    public function show($id)
    {
        $specialty = Specialty::with('subCategory')->find($id);

        if (! $specialty) {
            return $this->error(
                'specialty_not_found',
                404
            );
        }

        return $this->success(
            $specialty,
            'specialty_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $specialty = Specialty::find($id);

        if (! $specialty) {
            return $this->error(
                'specialty_not_found',
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'subcategory_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $specialty->update([
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
        ]);

        return $this->success(
            $specialty->load('subCategory'),
            'specialty_updated'
        );
    }

    public function destroy($id)
    {
        $specialty = Specialty::find($id);

        if (! $specialty) {
            return $this->error(
                'specialty_not_found',
                404
            );
        }

        $specialty->delete();

        return $this->success(
            null,
            'specialty_deleted'
        );
    }
}

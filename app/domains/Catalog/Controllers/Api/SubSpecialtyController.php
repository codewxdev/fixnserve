<?php

namespace App\Domains\Catalog\Controllers\Api;

use App\Domains\Catalog\Models\SubSpecialty;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubSpecialtyController extends BaseApiController
{
    public function index()
    {
        $subSpecialties = SubSpecialty::with('specialty')->get();

        return $this->success(
            $subSpecialties,
            'sub_specialties_fetched'
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $subSpecialty = SubSpecialty::create([
            'specialty_id' => $request->specialty_id,
            'name' => $request->name,
        ]);

        return $this->success(
            $subSpecialty->load('specialty'),
            'sub_specialty_created',
            201
        );
    }

    public function show($id)
    {
        $subSpecialty = SubSpecialty::with('specialty')->find($id);

        if (! $subSpecialty) {
            return $this->error(
                'sub_specialty_not_found',
                404
            );
        }

        return $this->success(
            $subSpecialty,
            'sub_specialty_fetched'
        );
    }

    public function update(Request $request, $id)
    {
        $subSpecialty = SubSpecialty::find($id);

        if (! $subSpecialty) {
            return $this->error(
                'sub_specialty_not_found',
                404
            );
        }

        $validator = Validator::make($request->all(), [
            'specialty_id' => 'required|exists:specialties,id',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->error(
                'validation_error',
                422,
                $validator->errors()
            );
        }

        $subSpecialty->update([
            'specialty_id' => $request->specialty_id,
            'name' => $request->name,
        ]);

        return $this->success(
            $subSpecialty->load('specialty'),
            'sub_specialty_updated'
        );
    }

    public function destroy($id)
    {
        $subSpecialty = SubSpecialty::find($id);

        if (! $subSpecialty) {
            return $this->error(
                'sub_specialty_not_found',
                404
            );
        }

        $subSpecialty->delete();

        return $this->success(
            null,
            'sub_specialty_deleted'
        );
    }
}

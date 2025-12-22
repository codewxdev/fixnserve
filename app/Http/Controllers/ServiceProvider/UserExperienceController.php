<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserExperienceController extends Controller
{
    public function index()
    {
        $experiences = auth()->user()
            ->experiences()
            ->orderByDesc('start_date')
            ->get();

        return ApiResponse::success(
            $experiences,
            'Experiences fetched successfully'
        );
    }

    public function show($id)
    {
        $experience = auth()->user()
            ->experiences()
            ->where('id', $id)
            ->first();

        if (! $experience) {
            return ApiResponse::notFound('Experience not found');
        }

        return ApiResponse::success(
            $experience,
            'Experience fetched successfully'
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'currently_working' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        if ($request->boolean('currently_working')) {
            $data['end_date'] = null;
        }

        $experience = auth()->user()->experiences()->create($data);

        return ApiResponse::success(
            $experience,
            'Experience added successfully',
            201
        );
    }

    public function update(Request $request, $id)
    {
        $experience = auth()->user()
            ->experiences()
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'currently_working' => 'required|boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);

        if ($request->boolean('currently_working')) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return ApiResponse::success(
            $experience,
            'Experience updated successfully'
        );
    }

    public function destroy($id)
    {
        $experience = auth()->user()
            ->experiences()
            ->where('id', $id)
            ->firstOrFail();

        $experience->delete();

        return ApiResponse::success(
            null,
            'Experience deleted successfully'
        );
    }
}

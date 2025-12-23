<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\UserCertificate;
use App\Models\UserEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserEducationController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();

        $educations = $user->educations()->get();
        $certificates = $user->certificates()->get()->map(function ($cert) {
            return [
                'id' => $cert->id,
                'image_url' => $cert->image_url,
                'created_at' => $cert->created_at->format('Y-m-d H:i:s'),
            ];
        });

        return ApiResponse::success([
            'educations' => $educations,
            'certificates' => $certificates,
        ], 'Profile data retrieved successfully');
    }

    public function storeProfile(Request $request)
    {
        $educationData = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'diploma' => 'nullable|string|max:255',
            'expected_diploma_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        \DB::beginTransaction();

        try {
            $education = Auth::user()->educations()->create($educationData);
            $certificates = [];

            if ($request->hasFile('certificates')) {
                $request->validate([
                    'certificates' => 'array',
                    'certificates.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
                ]);

                foreach ($request->file('certificates') as $file) {
                    $path = $file->store('certificates', 'public');
                    $certificate = Auth::user()->certificates()->create(['image' => $path]);

                    $certificates[] = [
                        'id' => $certificate->id,
                        'image_url' => asset('storage/'.$path),
                    ];
                }
            }

            \DB::commit();

            return ApiResponse::success([
                'education' => $education,
                'certificates' => $certificates,
            ], 'Education and certificates saved successfully', 201);

        } catch (\Exception $e) {
            \DB::rollback();

            return ApiResponse::error('Failed to save data: '.$e->getMessage(), 500);
        }
    }

    public function updateEducation(Request $request, $id)
    {
        $education = UserEducation::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'diploma' => 'nullable|string|max:255',
            'expected_diploma_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $education->update($validated);

        return ApiResponse::success($education, 'Education updated successfully');
    }

    public function uploadCertificates(Request $request)
    {
        $request->validate([
            'certificates' => 'required|array',
            'certificates.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
        ]);

        $uploadedCertificates = [];

        foreach ($request->file('certificates') as $file) {
            $path = $file->store('certificates', 'public');
            $certificate = Auth::user()->certificates()->create(['image' => $path]);

            $uploadedCertificates[] = [
                'id' => $certificate->id,
                'image_url' => asset('storage/'.$path),
            ];
        }

        return ApiResponse::success($uploadedCertificates, count($uploadedCertificates).' certificate(s) uploaded successfully', 201);
    }

    public function deleteEducation($id)
    {
        $education = UserEducation::where('user_id', Auth::id())->findOrFail($id);
        $education->delete();

        return ApiResponse::success(null, 'Education deleted successfully');
    }

    public function deleteCertificate($id)
    {
        $certificate = UserCertificate::where('user_id', Auth::id())->findOrFail($id);

        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Storage::disk('public')->delete($certificate->image);
        }

        $certificate->delete();

        return ApiResponse::success(null, 'Certificate deleted successfully');
    }

    public function downloadCertificate($id)
    {
        $certificate = UserCertificate::where('user_id', Auth::id())->findOrFail($id);

        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            $filename = basename($certificate->image);

            return Storage::disk('public')->download($certificate->image, $filename);
        }

        return ApiResponse::error('File not found', 404);
    }
}

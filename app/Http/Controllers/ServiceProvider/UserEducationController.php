<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\UserCertificate;
use App\Models\UserEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserEducationController extends Controller
{
    /**
     * Get user's complete profile including educations and certificates
     * GET /api/profile
     */
    public function getProfile()
    {
        $user = Auth::user();

        $educations = $user->educations()->get();
        $certificates = $user->certificates()->get();

        return response()->json([
            'success' => true,
            'data' => [
                'educations' => $educations,
                'certificates' => $certificates->map(function ($cert) {
                    return [
                        'id' => $cert->id,
                        'image_url' => $cert->image_url,
                        'created_at' => $cert->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
            ],
            'message' => 'Profile data retrieved successfully.',
        ]);
    }

    /**
     * Store education and certificates together
     * POST /api/profile
     */
    public function storeProfile(Request $request)
    {
        // Validate education data (required)
        $educationData = $request->validate([
            'school' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'diploma' => 'nullable|string|max:255',
            'expected_diploma_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        // Start transaction to ensure both operations complete
        \DB::beginTransaction();

        try {
            // 1. Save education
            $education = Auth::user()->educations()->create($educationData);

            // 2. Save certificates if provided
            $certificates = [];

            if ($request->hasFile('certificates')) {
                $request->validate([
                    'certificates' => 'array',
                    'certificates.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
                ]);

                foreach ($request->file('certificates') as $file) {
                    // Store file
                    $path = $file->store('certificates', 'public');

                    // Create certificate record with only image path
                    $certificate = Auth::user()->certificates()->create([
                        'image' => $path,
                    ]);

                    $certificates[] = [
                        'id' => $certificate->id,
                        'image_url' => asset('storage/'.$path),
                    ];
                }
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'education' => $education,
                    'certificates' => $certificates,
                ],
                'message' => 'Education and certificates saved successfully.',
            ], 201);

        } catch (\Exception $e) {
            \DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to save data: '.$e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update only education (certificates cannot be updated, only uploaded/deleted)
     * PUT /api/education/{id}
     */
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

        return response()->json([
            'success' => true,
            'data' => $education,
            'message' => 'Education updated successfully.',
        ]);
    }

    /**
     * Upload additional certificates (without education data)
     * POST /api/certificates/upload
     */
    public function uploadCertificates(Request $request)
    {
        $request->validate([
            'certificates' => 'required|array',
            'certificates.*' => 'image|mimes:jpeg,png,jpg,gif,svg,pdf|max:5120',
        ]);

        $uploadedCertificates = [];

        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $file) {
                // Store file
                $path = $file->store('certificates', 'public');

                // Create certificate record with only image path
                $certificate = Auth::user()->certificates()->create([
                    'image' => $path,
                ]);

                $uploadedCertificates[] = [
                    'id' => $certificate->id,
                    'image_url' => asset('storage/'.$path),
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $uploadedCertificates,
            'message' => count($uploadedCertificates).' certificate(s) uploaded successfully.',
        ], 201);
    }

    /**
     * Delete education
     * DELETE /api/education/{id}
     */
    public function deleteEducation($id)
    {
        $education = UserEducation::where('user_id', Auth::id())->findOrFail($id);
        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully.',
        ]);
    }

    /**
     * Delete certificate
     * DELETE /api/certificates/{id}
     */
    public function deleteCertificate($id)
    {
        $certificate = UserCertificate::where('user_id', Auth::id())->findOrFail($id);

        // Delete file from storage
        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Storage::disk('public')->delete($certificate->image);
        }

        // Delete record
        $certificate->delete();

        return response()->json([
            'success' => true,
            'message' => 'Certificate deleted successfully.',
        ]);
    }

    /**
     * Download certificate
     * GET /api/certificates/download/{id}
     */
    public function downloadCertificate($id)
    {
        $certificate = UserCertificate::where('user_id', Auth::id())->findOrFail($id);

        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            // Extract original filename from path if needed
            $filename = basename($certificate->image);

            return Storage::disk('public')->download(
                $certificate->image,
                $filename
            );
        }

        return response()->json([
            'success' => false,
            'message' => 'File not found.',
        ], 404);
    }
}

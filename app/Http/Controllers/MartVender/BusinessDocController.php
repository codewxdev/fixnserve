<?php

namespace App\Http\Controllers\MartVender;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BusinessDoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class BusinessDocController extends Controller
{
    public function index()
    {
        try {
            $docs = BusinessDoc::with('user')->latest()->get();

            return ApiResponse::success($docs, 'Business documents fetched successfully');
        } catch (Throwable $e) {
            return ApiResponse::error('Something went wrong', 500, $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = validator($request->all(), [
                'business_name' => 'required|string',
                'owner_name' => 'required|string',
                'business_type' => 'required|string',
                'location' => 'required|string',
                'email' => 'required|email',
                'tax_id' => 'nullable|string',
                'registration_number' => 'nullable|string',
                'permit_number' => 'nullable|string',
                'permit_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'tax_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'other_licenses' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                return ApiResponse::validationError($validator->errors()->toArray());
            }

            $data = $request->all();
            $data['user_id'] = Auth::id();
            $data['status'] = 'pending';

            foreach (['permit_document', 'tax_certificate', 'bank_statement', 'other_licenses'] as $file) {
                if ($request->hasFile($file)) {
                    $data[$file] = $request->file($file)->store('business_docs', 'public');
                }
            }

            $doc = BusinessDoc::create($data);

            return ApiResponse::success($doc, 'Business documents submitted successfully', 201);

        } catch (Throwable $e) {
            return ApiResponse::error('Failed to submit business documents', 500, $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $doc = BusinessDoc::with(['user', 'verifier'])->find($id);

            if (! $doc) {
                return ApiResponse::notFound('Business document not found');
            }

            return ApiResponse::success($doc, 'Business document fetched successfully');

        } catch (Throwable $e) {
            return ApiResponse::error('Something went wrong', 500, $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $doc = BusinessDoc::find($id);

            if (! $doc) {
                return ApiResponse::notFound('Business document not found');
            }

            if ($doc->user_id !== Auth::id()) {
                return ApiResponse::forbidden('You are not allowed to update this document');
            }

            $validator = validator($request->all(), [
                'business_name' => 'required|string',
                'owner_name' => 'required|string',
                'business_type' => 'required|string',
                'location' => 'required|string',
                'email' => 'required|email',
                'tax_id' => 'nullable|string',
                'registration_number' => 'nullable|string',
                'permit_number' => 'nullable|string',
                'permit_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'tax_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'bank_statement' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
                'other_licenses' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                return ApiResponse::validationError($validator->errors()->toArray());
            }

            $data = $request->all();

            foreach (['permit_document', 'tax_certificate', 'bank_statement', 'other_licenses'] as $file) {
                if ($request->hasFile($file)) {
                    if ($doc->$file) {
                        Storage::disk('public')->delete($doc->$file);
                    }
                    $data[$file] = $request->file($file)->store('business_docs', 'public');
                }
            }

            // Reset verification
            $data['status'] = 'pending';
            $data['verified_by'] = null;

            $doc->update($data);

            return ApiResponse::success($doc, 'Business documents updated successfully');

        } catch (Throwable $e) {
            return ApiResponse::error('Failed to update business documents', 500, $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $doc = BusinessDoc::find($id);

            if (! $doc) {
                return ApiResponse::notFound('Business document not found');
            }

            if ($doc->user_id !== Auth::id()) {
                return ApiResponse::forbidden('You are not allowed to delete this document');
            }

            foreach (['permit_document', 'tax_certificate', 'bank_statement', 'other_licenses'] as $file) {
                if ($doc->$file) {
                    Storage::disk('public')->delete($doc->$file);
                }
            }

            $doc->delete();

            return ApiResponse::success(null, 'Business documents deleted successfully');

        } catch (Throwable $e) {
            return ApiResponse::error('Failed to delete business documents', 500, $e->getMessage());
        }
    }

    public function verify(Request $request, $id)
    {
        try {
            $validator = validator($request->all(), [
                'status' => 'required|in:approved,rejected',
            ]);

            if ($validator->fails()) {
                return ApiResponse::validationError($validator->errors()->toArray());
            }

            $doc = BusinessDoc::find($id);

            if (! $doc) {
                return ApiResponse::notFound('Business document not found');
            }

            $doc->update([
                'status' => $request->status,
                'verified_by' => Auth::id(),
            ]);

            return ApiResponse::success($doc, 'Business document verified successfully');

        } catch (Throwable $e) {
            return ApiResponse::error('Failed to verify business document', 500, $e->getMessage());
        }
    }
}

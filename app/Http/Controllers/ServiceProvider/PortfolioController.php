<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return ApiResponse::error('Only service providers can see portfolio.', 403);
        }

        $portfolios = Portfolio::where('user_id', $user->id)->latest()->get();

        return ApiResponse::success([
            'user_id' => $user->id,
            'role' => $user->roles->pluck('name'),
            'portfolios' => $portfolios,
        ], 'Portfolios fetched successfully');
    }

    public function store(Request $request)
    {
        $skills = $request->skills;

        if (! is_array($skills)) {
            return ApiResponse::error('Skills must be an array of skill IDs.', 422);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_link' => 'nullable|url',
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('portfolio/images', 'public');
        }

        $portfolio = Portfolio::create([
            'project_title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? null,
            'role' => $request->input('role', 'Developer'),
            'user_id' => auth()->id(),
            'status' => 'draft',
        ]);

        $portfolio->skills()->sync($validated['skills']);

        return ApiResponse::success($portfolio->load('skills'), 'Portfolio created successfully', 201);
    }

    public function show($id)
    {
        $portfolio = Portfolio::with('skills')->findOrFail($id);

        return ApiResponse::success($portfolio, 'Portfolio fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return ApiResponse::error('Only service providers can update portfolio.', 403);
        }

        $portfolio = Portfolio::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->image = $request->file('image')->store('portfolio/images', 'public');
        }

        $portfolio->update([
            'project_title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $portfolio->image,
        ]);

        if (! empty($validated['skills'])) {
            $portfolio->skills()->sync($validated['skills']);
        }

        return ApiResponse::success($portfolio->load('skills'), 'Portfolio updated successfully');
    }

    public function destroy(Portfolio $portfolio)
    {
        $user = auth()->user();

        if (! $user->hasRole('service provider')) {
            return ApiResponse::error('Only service providers can delete portfolio.', 403);
        }

        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return ApiResponse::success(null, 'Portfolio deleted successfully');
    }

    public function addLanguage(Request $request)
    {
        $request->validate([
            'languages' => 'required|array',
            'languages.*.language' => 'required|string',
            'languages.*.proficiency' => 'required|string',
        ]);

        $user = auth()->user();
        $saved = [];

        foreach ($request->languages as $lang) {
            $saved[] = $user->languages()->create([
                'language' => $lang['language'],
                'proficiency' => $lang['proficiency'],
            ]);
        }

        return ApiResponse::success($saved, 'Languages added successfully');
    }
}

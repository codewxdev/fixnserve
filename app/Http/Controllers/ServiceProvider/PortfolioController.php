<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Only service providers can update
        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can see portfolio.',
            ], 403);
        }

        $portfolios = Portfolio::where('user_id', $user->id)->latest()->get();

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'role' => $user->role,
            'portfolios' => $portfolios,
        ]);
    }

    public function store(Request $request)
    {
        // Ensure skills is interpreted as an array
        $skills = $request->skills;

        if (! is_array($skills)) {
            return response()->json([
                'status' => false,
                'message' => 'Skills must be an array of skill IDs.',
            ], 422);
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
            'role' => $request->input('role', 'Developer'), // or whatever default
            'user_id' => auth()->id(),
            'status' => 'draft', // or from request
        ]);

        // Attach skills to pivot table (each skill gets its own row)
        $portfolio->skills()->sync($validated['skills']);

        return response()->json([
            'message' => 'Portfolio created successfully',
            'portfolio' => $portfolio->load('skills'),
        ]);
    }

    public function show($id)
    {
        $portfolio = Portfolio::with('skills')->findOrFail($id);

        return response()->json([
            'success' => true,
            'portfolio' => $portfolio, // note: singular
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        // Only service providers can update
        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can update portfolio.',
            ], 403);
        }

        // Find the portfolio first
        $portfolio = Portfolio::findOrFail($id);

        // Validate request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:skills,id',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($portfolio->image) {
                Storage::disk('public')->delete($portfolio->image);
            }
            $portfolio->image = $request->file('image')->store('portfolio/images', 'public');
        }

        // Update basic fields
        $portfolio->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'image' => $portfolio->image, // already updated if new file uploaded
        ]);

        // Sync skills if provided
        if (! empty($validated['skills'])) {
            $portfolio->skills()->sync($validated['skills']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Portfolio updated successfully',
            'portfolio' => $portfolio->load('skills'),
        ]);
    }

    public function destroy(Portfolio $portfolio)
    {
        $user = auth()->user();
        // Only service providers can update
        if (! $user->hasRole('service provider')) {
            return response()->json([
                'status' => false,
                'message' => 'Only service providers can delete portfolio',
            ], 403);
        }

        if ($portfolio->image) {
            Storage::disk('public')->delete($portfolio->image);
        }

        $portfolio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Portfolio deleted successfully',
        ]);
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

        return response()->json([
            'message' => 'Languages added successfully',
            'data' => $saved,
        ]);
    }
}

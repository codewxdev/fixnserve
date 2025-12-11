<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Skill::all(),
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $skill = Skill::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Skill created successfully',
            'data' => $skill,
        ], 201);
    }

    public function show($id)
    {
        $skill = Skill::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $skill,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $skill->update($request->only('name'));

        return response()->json([
            'status' => true,
            'message' => 'Skill updated successfully',
            'data' => $skill,
        ], 200);
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return response()->json([
            'status' => true,
            'message' => 'Skill deleted successfully',
        ], 200);
    }

    public function suggested()
    {
        $skills = Skill::limit(12)->get();

        return response()->json([
            'skills' => $skills,
        ]);
    }

    public function search(Request $request)
    {
        $query = trim($request->query('query'));

        // If no query → return empty list
        if (! $query || $query === '') {
            return response()->json([
                'skills' => [],
            ]);
        }

        // Search only matching skills
        $skills = Skill::where('name', 'LIKE', "%{$query}%")
            ->get();

        return response()->json([
            'skills' => $skills,
        ]);
    }

    public function addSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = auth()->user();

        // Sync means: only these skills → old ones removed
        $user->skills()->sync($request->skills);

        return response()->json([
            'message' => 'Skills updated successfully',
            'skills' => $user->skills()->get(),
        ]);
    }

}

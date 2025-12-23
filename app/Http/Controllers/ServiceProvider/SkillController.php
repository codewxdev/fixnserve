<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::all();

        return ApiResponse::success($skills, 'Skills fetched successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill = Skill::create([
            'name' => $request->name,
        ]);

        return ApiResponse::success($skill, 'Skill created successfully', 201);
    }

    public function show($id)
    {
        $skill = Skill::findOrFail($id);

        return ApiResponse::success($skill, 'Skill fetched successfully');
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill->update($request->only('name'));

        return ApiResponse::success($skill, 'Skill updated successfully');
    }

    public function destroy($id)
    {
        $skill = Skill::findOrFail($id);
        $skill->delete();

        return ApiResponse::success(null, 'Skill deleted successfully');
    }

    public function suggested()
    {
        $skills = Skill::limit(12)->get();

        return ApiResponse::success($skills, 'Suggested skills fetched successfully');
    }

    public function search(Request $request)
    {
        $query = trim($request->query('query'));

        if (! $query || $query === '') {
            return ApiResponse::success([], 'No skills found');
        }

        $skills = Skill::where('name', 'LIKE', "%{$query}%")->get();

        return ApiResponse::success($skills, 'Skills fetched successfully');
    }

    public function addSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = auth()->user();

        // Already attached skills
        $existingSkillIds = $user->skills()->pluck('skills.id')->toArray();

        // Sirf new skills (duplicates remove)
        $newSkills = array_diff($request->skills, $existingSkillIds);

        // Agar kuch naya add hi nahi ho raha
        if (empty($newSkills)) {
            return ApiResponse::success(
                $user->skills()->get(),
                'No new skills to add'
            );
        }

        // Total skills limit check
        $totalSkills = count($existingSkillIds) + count($newSkills);

        if ($totalSkills > 5) {
            return ApiResponse::error(
                'You can add maximum 5 skills only.',
                422
            );
        }

        // Attach only new skills
        $user->skills()->attach($newSkills);

        return ApiResponse::success(
            $user->skills()->get(),
            'Skills added successfully'
        );
    }
}

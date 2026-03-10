<?php

namespace App\Domains\Catalog\Admin\Controllers\Api;

use App\Domains\Catalog\Admin\Models\Skill;
use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;

class SkillController extends BaseApiController
{
    public function index()
    {
        $skills = Skill::all();

        return $this->success($skills, 'skills_fetched');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill = Skill::create([
            'name' => $request->name,
        ]);

        return $this->success($skill, 'skill_created', 201);
    }

    public function show($id)
    {
        $skill = Skill::find($id);

        if (! $skill) {
            return $this->error('skill_not_found', 404);
        }

        return $this->success($skill, 'skill_fetched');
    }

    public function update(Request $request, $id)
    {
        $skill = Skill::find($id);

        if (! $skill) {
            return $this->error('skill_not_found', 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $skill->update($request->only('name'));

        return $this->success($skill, 'skill_updated');
    }

    public function destroy($id)
    {
        $skill = Skill::find($id);

        if (! $skill) {
            return $this->error('skill_not_found', 404);
        }

        $skill->delete();

        return $this->success(null, 'skill_deleted');
    }

    public function suggested()
    {
        $skills = Skill::limit(12)->get();

        return $this->success($skills, 'suggested_skills_fetched');
    }

    public function search(Request $request)
    {
        $query = trim($request->query('query'));

        if (! $query) {
            return $this->success([], 'no_skills_found');
        }

        $skills = Skill::where('name', 'LIKE', "%{$query}%")->get();

        return $this->success($skills, 'skills_fetched');
    }

    public function addSkills(Request $request)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $user = auth()->user();

        $existingSkillIds = $user->skills()->pluck('skills.id')->toArray();

        $newSkills = array_diff($request->skills, $existingSkillIds);

        if (empty($newSkills)) {
            return $this->success(
                $user->skills()->get(),
                'no_new_skills_to_add'
            );
        }

        $totalSkills = count($existingSkillIds) + count($newSkills);

        if ($totalSkills > 5) {
            return $this->error(
                'maximum_5_skills_allowed',
                422
            );
        }

        $user->skills()->attach($newSkills);

        return $this->success(
            $user->skills()->get(),
            'skills_added'
        );
    }
}

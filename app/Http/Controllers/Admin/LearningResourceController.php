<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLearningResourceRequest;
use App\Http\Requests\UpdateLearningResourceRequest;
use App\Models\LearningResource;
use App\Models\Skill;

class LearningResourceController extends Controller
{
    public function index()
    {
        $resources = LearningResource::with(['skill.stage.careerPath'])->latest()->paginate(20);
        return view('admin.resources.index', compact('resources'));
    }

    public function create()
    {
        $skills = Skill::with(['stage.careerPath'])->get();
        return view('admin.resources.create', compact('skills'));
    }

    public function store(StoreLearningResourceRequest $request)
    {
        LearningResource::create($request->validated());
        return redirect()->route('admin.skills.show', $request->skill_id)
            ->with('success', 'Learning resource created successfully!');
    }

    public function show(LearningResource $learningResource)
    {
        $learningResource->load(['skill.stage.careerPath']);
        return view('admin.resources.show', compact('learningResource'));
    }

    public function edit(LearningResource $learningResource)
    {
        $skills = Skill::with(['stage.careerPath'])->get();
        return view('admin.resources.edit', compact('learningResource', 'skills'));
    }

    public function update(UpdateLearningResourceRequest $request, LearningResource $learningResource)
    {
        $learningResource->update($request->validated());
        return redirect()->route('admin.skills.show', $learningResource->skill_id)
            ->with('success', 'Learning resource updated successfully!');
    }

    public function destroy(LearningResource $learningResource)
    {
        $skillId = $learningResource->skill_id;
        $learningResource->delete();
        return redirect()->route('admin.skills.show', $skillId)
            ->with('success', 'Learning resource deleted successfully!');
    }
}

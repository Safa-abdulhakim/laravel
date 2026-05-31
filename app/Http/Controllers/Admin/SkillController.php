<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use App\Models\Stage;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with(['stage.careerPath'])->withCount('learningResources')->latest()->paginate(20);
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        $stages = Stage::with('careerPath')->get();
        return view('admin.skills.create', compact('stages'));
    }

    public function store(StoreSkillRequest $request)
    {
        $data = $request->validated();
        if (empty($data['order'])) {
            $data['order'] = Skill::where('stage_id', $data['stage_id'])->max('order') + 1;
        }
        Skill::create($data);

        return redirect()->route('admin.stages.show', $data['stage_id'])
            ->with('success', 'Skill created successfully!');
    }

    public function show(Skill $skill)
    {
        $skill->load(['stage.careerPath', 'learningResources']);
        return view('admin.skills.show', compact('skill'));
    }

    public function edit(Skill $skill)
    {
        $stages = Stage::with('careerPath')->get();
        return view('admin.skills.edit', compact('skill', 'stages'));
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $skill->update($request->validated());
        return redirect()->route('admin.stages.show', $skill->stage_id)
            ->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        $stageId = $skill->stage_id;
        $skill->delete();
        return redirect()->route('admin.stages.show', $stageId)
            ->with('success', 'Skill deleted successfully!');
    }
}

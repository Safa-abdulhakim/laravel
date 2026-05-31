<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStageRequest;
use App\Http\Requests\UpdateStageRequest;
use App\Models\CareerPath;
use App\Models\Stage;

class StageController extends Controller
{
    public function index()
    {
        $stages = Stage::with('careerPath')->withCount('skills')->latest()->paginate(20);
        return view('admin.stages.index', compact('stages'));
    }

    public function create()
    {
        $careerPaths = CareerPath::where('status', 'active')->get();
        return view('admin.stages.create', compact('careerPaths'));
    }

    public function store(StoreStageRequest $request)
    {
        $data = $request->validated();
        if (empty($data['order'])) {
            $data['order'] = Stage::where('career_path_id', $data['career_path_id'])->max('order') + 1;
        }
        Stage::create($data);

        return redirect()->route('admin.career-paths.show', $data['career_path_id'])
            ->with('success', 'Stage created successfully!');
    }

    public function show(Stage $stage)
    {
        $stage->load(['careerPath', 'skills.learningResources']);
        return view('admin.stages.show', compact('stage'));
    }

    public function edit(Stage $stage)
    {
        $careerPaths = CareerPath::where('status', 'active')->get();
        return view('admin.stages.edit', compact('stage', 'careerPaths'));
    }

    public function update(UpdateStageRequest $request, Stage $stage)
    {
        $stage->update($request->validated());
        return redirect()->route('admin.career-paths.show', $stage->career_path_id)
            ->with('success', 'Stage updated successfully!');
    }

    public function destroy(Stage $stage)
    {
        $careerPathId = $stage->career_path_id;
        $stage->delete();
        return redirect()->route('admin.career-paths.show', $careerPathId)
            ->with('success', 'Stage deleted successfully!');
    }
}

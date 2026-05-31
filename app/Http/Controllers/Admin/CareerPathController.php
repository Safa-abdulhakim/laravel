<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCareerPathRequest;
use App\Http\Requests\UpdateCareerPathRequest;
use App\Models\CareerPath;
use Illuminate\Support\Str;

class CareerPathController extends Controller
{
    public function index()
    {
        $careerPaths = CareerPath::withCount(['stages', 'skills'])
            ->latest()
            ->paginate(15);

        return view('admin.career-paths.index', compact('careerPaths'));
    }

    public function create()
    {
        return view('admin.career-paths.create');
    }

    public function store(StoreCareerPathRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('career-paths', 'public');
        }

        CareerPath::create($data);

        return redirect()->route('admin.career-paths.index')
            ->with('success', 'Career path created successfully!');
    }

    public function show(CareerPath $careerPath)
    {
        $careerPath->load(['stages.skills.learningResources']);
        return view('admin.career-paths.show', compact('careerPath'));
    }

    public function edit(CareerPath $careerPath)
    {
        return view('admin.career-paths.edit', compact('careerPath'));
    }

    public function update(UpdateCareerPathRequest $request, CareerPath $careerPath)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('career-paths', 'public');
        }

        $careerPath->update($data);

        return redirect()->route('admin.career-paths.index')
            ->with('success', 'Career path updated successfully!');
    }

    public function destroy(CareerPath $careerPath)
    {
        $careerPath->delete();

        return redirect()->route('admin.career-paths.index')
            ->with('success', 'Career path deleted successfully!');
    }
}

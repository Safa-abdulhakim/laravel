<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('images')->orderBy('sort_order')->paginate(15);
        return view('dashboard.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('dashboard.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'overview' => 'nullable|string',
            'overview_ar' => 'nullable|string',
            'features' => 'nullable|string',
            'features_ar' => 'nullable|string',
            'challenges' => 'nullable|string',
            'challenges_ar' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string',
            'github_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'category' => 'required|string',
            'featured' => 'boolean',
            'sort_order' => 'integer',
            'cover_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project = Project::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $path = $image->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', __('messages.created_success'));
    }

    public function edit(Project $project)
    {
        return view('dashboard.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'overview' => 'nullable|string',
            'overview_ar' => 'nullable|string',
            'features' => 'nullable|string',
            'features_ar' => 'nullable|string',
            'challenges' => 'nullable|string',
            'challenges_ar' => 'nullable|string',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string',
            'github_link' => 'nullable|url',
            'demo_link' => 'nullable|url',
            'category' => 'required|string',
            'featured' => 'boolean',
            'sort_order' => 'integer',
            'cover_image' => 'nullable|image|max:2048',
            'gallery.*' => 'nullable|image|max:2048',
        ]);

        $data['featured'] = $request->boolean('featured');
        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) Storage::disk('public')->delete($project->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('projects', 'public');
        }

        $project->update($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $image) {
                $path = $image->store('projects/gallery', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'sort_order' => $project->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')->with('success', __('messages.updated_success'));
    }

    public function destroy(Project $project)
    {
        if ($project->cover_image) Storage::disk('public')->delete($project->cover_image);
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', __('messages.deleted_success'));
    }

    public function deleteImage(ProjectImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', __('messages.deleted_success'));
    }
}

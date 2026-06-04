<?php
namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with('images');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('tech')) {
            $query->whereJsonContains('technologies', $request->tech);
        }

        $projects = $query->orderBy('featured', 'desc')->orderBy('sort_order')->paginate(9);
        $categories = Project::distinct()->pluck('category');
        $technologies = Project::all()->pluck('technologies')->flatten()->unique()->filter()->values();

        return view('projects.index', compact('projects', 'categories', 'technologies'));
    }

    public function show(string $slug)
    {
        $project = Project::with('images')->where('slug', $slug)->firstOrFail();
        $related = Project::where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->take(3)->get();
        return view('projects.show', compact('project', 'related'));
    }
}

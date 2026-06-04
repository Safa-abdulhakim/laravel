<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Testimonial;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProjects = Project::where('featured', true)->orderBy('sort_order')->take(6)->get();
        $skills = Skill::orderBy('category')->orderBy('sort_order')->get();
        $skillsByCategory = $skills->groupBy('category');
        $experiences = Experience::orderByDesc('start_date')->get();
        $certificates = Certificate::orderByDesc('issue_date')->get();
        $testimonials = Testimonial::where('is_visible', true)->orderBy('sort_order')->get();
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'certificates' => Certificate::count(),
            'experience_years' => $this->calculateYearsOfExperience(),
        ];
        return view('home.index', compact(
            'featuredProjects', 'skillsByCategory', 'experiences',
            'certificates', 'testimonials', 'stats'
        ));
    }

    private function calculateYearsOfExperience(): int
    {
        $earliest = Experience::min('start_date');
        if (!$earliest) return 0;
        return (int) now()->diffInYears($earliest);
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Message;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'certificates' => Certificate::count(),
            'messages' => Message::count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'testimonials' => Testimonial::count(),
        ];
        $recentMessages = Message::latest()->take(5)->get();
        $recentProjects = Project::latest()->take(5)->get();
        $skillsByCategory = Skill::all()->groupBy('category');

        return view('dashboard.index', compact('stats', 'recentMessages', 'recentProjects', 'skillsByCategory'));
    }
}

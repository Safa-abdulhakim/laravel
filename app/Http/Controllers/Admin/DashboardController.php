<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\Message;
use App\Models\Cv;

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
            'new_messages' => Message::where('status', 'new')->count(),
        ];

        $projectsByStatus = [
            'featured' => Project::where('status', 'featured')->count(),
            'active' => Project::where('status', 'active')->count(),
            'inactive' => Project::where('status', 'inactive')->count(),
        ];

        $skillsByCategory = Skill::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        $recentProjects = Project::latest()->take(5)->get();
        $recentMessages = Message::latest()->take(5)->get();
        $activeCv = Cv::where('is_active', true)->latest()->first();

        return view('admin.dashboard', compact(
            'stats', 'projectsByStatus', 'skillsByCategory',
            'recentProjects', 'recentMessages', 'activeCv'
        ));
    }
}

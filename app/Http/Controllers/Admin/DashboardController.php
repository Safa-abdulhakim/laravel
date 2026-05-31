<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerPath;
use App\Models\LearningResource;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkillProgress;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'career_paths' => CareerPath::count(),
            'skills' => Skill::count(),
            'resources' => LearningResource::count(),
        ];

        $topPaths = CareerPath::withCount(['stages', 'skills'])
            ->orderByDesc('enrolled_count')
            ->take(5)
            ->get();

        $recentUsers = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get();

        $skillProgressStats = [
            'completed' => UserSkillProgress::where('status', 'completed')->count(),
            'in_progress' => UserSkillProgress::where('status', 'in_progress')->count(),
            'not_started' => UserSkillProgress::where('status', 'not_started')->count(),
        ];

        $pathDifficultyStats = [
            'Beginner' => CareerPath::where('difficulty_level', 'Beginner')->count(),
            'Intermediate' => CareerPath::where('difficulty_level', 'Intermediate')->count(),
            'Advanced' => CareerPath::where('difficulty_level', 'Advanced')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'topPaths', 'recentUsers', 'skillProgressStats', 'pathDifficultyStats'));
    }
}

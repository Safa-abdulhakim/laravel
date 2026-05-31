<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\UserAchievement;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private ProgressService $progressService) {}

    public function index()
    {
        $user = auth()->user();
        $enrolledPaths = $user->getEnrolledCareerPaths();

        $pathsWithProgress = $enrolledPaths->map(function ($path) use ($user) {
            $progress = $this->progressService->getCareerPathProgress($user, $path);
            $path->progress = $progress;
            return $path;
        });

        $overallProgress = $this->progressService->getOverallProgress($user);

        $completedSkills = $user->skillProgress()
            ->where('status', 'completed')
            ->with('skill')
            ->latest('completed_at')
            ->take(5)
            ->get();

        $totalCompleted = $user->skillProgress()->where('status', 'completed')->count();
        $totalInProgress = $user->skillProgress()->where('status', 'in_progress')->count();

        $recentAchievements = UserAchievement::where('user_id', $user->id)
            ->with(['achievement', 'careerPath'])
            ->latest('earned_at')
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'pathsWithProgress',
            'overallProgress',
            'completedSkills',
            'totalCompleted',
            'totalInProgress',
            'recentAchievements'
        ));
    }
}

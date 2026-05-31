<?php

namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\Skill;
use App\Services\AchievementService;
use App\Services\ProgressService;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function __construct(
        private ProgressService $progressService,
        private AchievementService $achievementService
    ) {}

    public function update(Request $request, CareerPath $careerPath, Skill $skill)
    {
        $request->validate([
            'status' => 'required|in:not_started,in_progress,completed',
        ]);

        $user = auth()->user();
        $this->progressService->updateSkillStatus($user, $skill, $careerPath, $request->status);

        $newAchievements = $this->achievementService->checkAndAward($user, $careerPath);
        $progress = $this->progressService->getCareerPathProgress($user, $careerPath);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'status' => $request->status,
                'progress' => $progress,
                'new_achievements' => $newAchievements->map(fn($a) => [
                    'title' => $a->title,
                    'badge_icon' => $a->badge_icon,
                    'badge_color' => $a->badge_color,
                ]),
            ]);
        }

        $message = match($request->status) {
            'completed' => 'Skill marked as completed!',
            'in_progress' => 'Skill started!',
            default => 'Skill status updated.',
        };

        return back()->with('success', $message);
    }

    public function enrollPath(CareerPath $careerPath)
    {
        $user = auth()->user();
        $careerPath->increment('enrolled_count');

        $firstSkill = $careerPath->skills()->first();
        if ($firstSkill) {
            $this->progressService->updateSkillStatus($user, $firstSkill, $careerPath, 'not_started');
        }

        return redirect()->route('career-paths.show', $careerPath)
            ->with('success', "You enrolled in '{$careerPath->title}' successfully!");
    }
}

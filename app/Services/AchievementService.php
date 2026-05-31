<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\CareerPath;
use App\Models\User;
use App\Models\UserAchievement;

class AchievementService
{
    public function __construct(private ProgressService $progressService) {}

    public function checkAndAward(User $user, CareerPath $careerPath): array
    {
        $progress = $this->progressService->getCareerPathProgress($user, $careerPath);
        $percentage = $progress['percentage'];
        $newAchievements = [];

        $thresholds = [
            'first_skill' => 0,
            'progress_25' => 25,
            'progress_50' => 50,
            'progress_75' => 75,
            'progress_100' => 100,
        ];

        foreach ($thresholds as $type => $threshold) {
            if ($type === 'first_skill' && $progress['completed'] >= 1) {
                $achievement = Achievement::where('type', 'first_skill')->first();
                if ($achievement && $this->awardIfNotEarned($user, $achievement, $careerPath)) {
                    $newAchievements[] = $achievement;
                }
                continue;
            }

            if ($percentage >= $threshold && $threshold > 0) {
                $achievement = Achievement::where('type', $type)->first();
                if ($achievement && $this->awardIfNotEarned($user, $achievement, $careerPath)) {
                    $newAchievements[] = $achievement;
                }
            }
        }

        return $newAchievements;
    }

    private function awardIfNotEarned(User $user, Achievement $achievement, CareerPath $careerPath): bool
    {
        $exists = UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->where('career_path_id', $careerPath->id)
            ->exists();

        if (!$exists) {
            UserAchievement::create([
                'user_id' => $user->id,
                'achievement_id' => $achievement->id,
                'career_path_id' => $careerPath->id,
                'earned_at' => now(),
            ]);
            return true;
        }

        return false;
    }
}

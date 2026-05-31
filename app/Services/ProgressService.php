<?php

namespace App\Services;

use App\Models\CareerPath;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserSkillProgress;

class ProgressService
{
    public function updateSkillStatus(User $user, Skill $skill, CareerPath $careerPath, string $status): UserSkillProgress
    {
        $progress = UserSkillProgress::firstOrCreate(
            ['user_id' => $user->id, 'skill_id' => $skill->id, 'career_path_id' => $careerPath->id],
            ['status' => 'not_started']
        );

        $data = ['status' => $status];

        if ($status === 'in_progress' && !$progress->started_at) {
            $data['started_at'] = now();
        }

        if ($status === 'completed') {
            if (!$progress->started_at) {
                $data['started_at'] = now();
            }
            $data['completed_at'] = now();
        }

        $progress->update($data);

        return $progress;
    }

    public function getCareerPathProgress(User $user, CareerPath $careerPath): array
    {
        $totalSkills = $careerPath->skills()->count();

        if ($totalSkills === 0) {
            return ['percentage' => 0, 'completed' => 0, 'in_progress' => 0, 'total' => 0];
        }

        $progress = UserSkillProgress::where('user_id', $user->id)
            ->where('career_path_id', $careerPath->id)
            ->get();

        $completed = $progress->where('status', 'completed')->count();
        $inProgress = $progress->where('status', 'in_progress')->count();

        return [
            'percentage' => round(($completed / $totalSkills) * 100, 1),
            'completed' => $completed,
            'in_progress' => $inProgress,
            'total' => $totalSkills,
            'remaining' => $totalSkills - $completed,
        ];
    }

    public function getStageProgress(User $user, $stage, CareerPath $careerPath): array
    {
        $totalSkills = $stage->skills()->count();

        if ($totalSkills === 0) {
            return ['percentage' => 0, 'completed' => 0, 'total' => 0];
        }

        $skillIds = $stage->skills()->pluck('id');
        $completed = UserSkillProgress::where('user_id', $user->id)
            ->where('career_path_id', $careerPath->id)
            ->whereIn('skill_id', $skillIds)
            ->where('status', 'completed')
            ->count();

        return [
            'percentage' => round(($completed / $totalSkills) * 100, 1),
            'completed' => $completed,
            'total' => $totalSkills,
        ];
    }

    public function getOverallProgress(User $user): float
    {
        $enrolledPaths = $user->getEnrolledCareerPaths();

        if ($enrolledPaths->isEmpty()) return 0;

        $total = 0;
        foreach ($enrolledPaths as $path) {
            $total += $this->getCareerPathProgress($user, $path)['percentage'];
        }

        return round($total / $enrolledPaths->count(), 1);
    }

    public function getSkillStatus(User $user, Skill $skill, CareerPath $careerPath): string
    {
        $progress = UserSkillProgress::where('user_id', $user->id)
            ->where('skill_id', $skill->id)
            ->where('career_path_id', $careerPath->id)
            ->first();

        return $progress?->status ?? 'not_started';
    }
}

<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'title' => 'First Step',
                'description' => 'Completed your first skill!',
                'badge_icon' => 'bi-star',
                'badge_color' => '#4CAF50',
                'type' => 'first_skill',
                'required_percentage' => 0,
            ],
            [
                'title' => 'Getting Started',
                'description' => 'Reached 25% progress on a career path!',
                'badge_icon' => 'bi-trophy',
                'badge_color' => '#2196F3',
                'type' => 'progress_25',
                'required_percentage' => 25,
            ],
            [
                'title' => 'Halfway There',
                'description' => 'Reached 50% progress on a career path!',
                'badge_icon' => 'bi-award',
                'badge_color' => '#9C27B0',
                'type' => 'progress_50',
                'required_percentage' => 50,
            ],
            [
                'title' => 'Almost There',
                'description' => 'Reached 75% progress on a career path!',
                'badge_icon' => 'bi-gem',
                'badge_color' => '#FF9800',
                'type' => 'progress_75',
                'required_percentage' => 75,
            ],
            [
                'title' => 'Path Master',
                'description' => 'Completed 100% of a career path!',
                'badge_icon' => 'bi-patch-check-fill',
                'badge_color' => '#FFD700',
                'type' => 'progress_100',
                'required_percentage' => 100,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::firstOrCreate(['type' => $achievement['type']], $achievement);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar', 'bio'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function skillProgress()
    {
        return $this->hasMany(UserSkillProgress::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('career_path_id', 'earned_at')
            ->withTimestamps();
    }

    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function getEnrolledCareerPaths()
    {
        return CareerPath::whereIn('id',
            $this->skillProgress()->pluck('career_path_id')->unique()
        )->get();
    }

    public function getProgressForCareerPath(CareerPath $careerPath): float
    {
        $totalSkills = $careerPath->skills()->count();
        if ($totalSkills === 0) return 0;

        $completedSkills = $this->skillProgress()
            ->where('career_path_id', $careerPath->id)
            ->where('status', 'completed')
            ->count();

        return round(($completedSkills / $totalSkills) * 100, 1);
    }
}

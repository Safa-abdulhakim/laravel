<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CareerPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'icon', 'image',
        'difficulty_level', 'estimated_duration', 'status', 'enrolled_count',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }

    public function stages()
    {
        return $this->hasMany(Stage::class)->orderBy('order');
    }

    public function skills()
    {
        return $this->hasManyThrough(Skill::class, Stage::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserSkillProgress::class);
    }

    public function userAchievements()
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function getTotalSkillsCountAttribute()
    {
        return $this->skills()->count();
    }

    public function getDifficultyColorAttribute()
    {
        return match($this->difficulty_level) {
            'Beginner' => 'success',
            'Intermediate' => 'warning',
            'Advanced' => 'danger',
            default => 'secondary',
        };
    }
}

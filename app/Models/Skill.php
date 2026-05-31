<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['stage_id', 'title', 'description', 'estimated_hours', 'difficulty', 'order'];

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function learningResources()
    {
        return $this->hasMany(LearningResource::class);
    }

    public function userProgress()
    {
        return $this->hasMany(UserSkillProgress::class);
    }

    public function getDifficultyColorAttribute()
    {
        return match($this->difficulty) {
            'Beginner' => 'success',
            'Intermediate' => 'warning',
            'Advanced' => 'danger',
            default => 'secondary',
        };
    }
}

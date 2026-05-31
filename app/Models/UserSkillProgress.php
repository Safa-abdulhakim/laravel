<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSkillProgress extends Model
{
    protected $fillable = [
        'user_id', 'skill_id', 'career_path_id', 'status', 'started_at', 'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function careerPath()
    {
        return $this->belongsTo(CareerPath::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            default => 'Not Started',
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'in_progress' => 'warning',
            'completed' => 'success',
            default => 'secondary',
        };
    }
}

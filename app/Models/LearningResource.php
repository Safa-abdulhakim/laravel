<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningResource extends Model
{
    use HasFactory;

    protected $fillable = ['skill_id', 'title', 'type', 'url', 'provider'];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'Video' => 'bi-play-circle',
            'Course' => 'bi-book',
            'Documentation' => 'bi-file-text',
            default => 'bi-newspaper',
        };
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'Video' => 'danger',
            'Course' => 'primary',
            'Documentation' => 'info',
            default => 'secondary',
        };
    }
}

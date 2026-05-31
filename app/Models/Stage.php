<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = ['career_path_id', 'title', 'description', 'order'];

    public function careerPath()
    {
        return $this->belongsTo(CareerPath::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class)->orderBy('order');
    }
}

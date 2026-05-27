<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'percentage', 'category', 'icon', 'sort_order'];

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}

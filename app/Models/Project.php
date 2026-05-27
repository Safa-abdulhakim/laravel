<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'gallery',
        'github_link', 'live_demo', 'technologies', 'status', 'sort_order'
    ];

    protected $casts = [
        'gallery' => 'array',
        'technologies' => 'array',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('status', 'featured');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['active', 'featured']);
    }
}

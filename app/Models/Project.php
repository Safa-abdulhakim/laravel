<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'title_ar', 'slug', 'description', 'description_ar',
        'overview', 'overview_ar', 'features', 'features_ar',
        'challenges', 'challenges_ar', 'cover_image', 'technologies',
        'github_link', 'demo_link', 'category', 'featured', 'sort_order'
    ];

    protected $casts = [
        'technologies' => 'array',
        'featured' => 'boolean',
    ];

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function getTranslatedTitle()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->title_ar ? $this->title_ar : $this->title;
    }

    public function getTranslatedDescription()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->description_ar ? $this->description_ar : $this->description;
    }

    public function getTranslatedOverview()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->overview_ar ? $this->overview_ar : $this->overview;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title);
            }
        });
    }
}

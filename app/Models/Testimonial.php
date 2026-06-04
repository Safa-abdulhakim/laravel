<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'name', 'name_ar', 'position', 'position_ar', 'company',
        'content', 'content_ar', 'avatar', 'rating', 'is_visible', 'sort_order'
    ];

    protected $casts = ['is_visible' => 'boolean'];

    public function getTranslatedContent()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->content_ar ? $this->content_ar : $this->content;
    }
}

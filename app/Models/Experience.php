<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company_name', 'company_name_ar', 'position', 'position_ar',
        'start_date', 'end_date', 'is_current', 'description', 'description_ar',
        'location', 'company_logo', 'sort_order'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    public function getTranslatedCompany()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->company_name_ar ? $this->company_name_ar : $this->company_name;
    }

    public function getTranslatedPosition()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->position_ar ? $this->position_ar : $this->position;
    }

    public function getDuration()
    {
        $start = $this->start_date;
        $end = $this->is_current ? now() : $this->end_date;
        $months = $start->diffInMonths($end);
        $years = floor($months / 12);
        $remainingMonths = $months % 12;
        $duration = '';
        if ($years > 0) $duration .= $years . ' yr' . ($years > 1 ? 's' : '');
        if ($remainingMonths > 0) $duration .= ($duration ? ' ' : '') . $remainingMonths . ' mo' . ($remainingMonths > 1 ? 's' : '');
        return $duration ?: '< 1 mo';
    }
}

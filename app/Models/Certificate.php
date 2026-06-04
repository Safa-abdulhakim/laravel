<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'title', 'title_ar', 'issuer', 'issuer_ar',
        'issue_date', 'expiry_date', 'credential_id', 'credential_url', 'image', 'sort_order'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function getTranslatedTitle()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->title_ar ? $this->title_ar : $this->title;
    }

    public function getTranslatedIssuer()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' && $this->issuer_ar ? $this->issuer_ar : $this->issuer;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    protected $fillable = ['file_path', 'original_name', 'file_size', 'is_active', 'download_count'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function incrementDownload()
    {
        $this->increment('download_count');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    protected $table = 'cvs';
    protected $fillable = ['file_path', 'file_name', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
}

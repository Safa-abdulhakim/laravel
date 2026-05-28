<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prompt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'category_id', 'title', 'prompt_content',
        'platform', 'status', 'favorite', 'views'
    ];

    protected $casts = ['favorite' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'prompt_tag');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function scopePublic($query)
    {
        return $query->where('status', 'public');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('prompt_content', 'like', "%{$search}%");
        });
    }
}

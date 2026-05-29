<?php
namespace App\Http\Controllers;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPrompts = Prompt::with(['user', 'category', 'tags'])
            ->where('status', 'public')
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        $categories = Category::withCount(['prompts' => function($q) {
            $q->where('status', 'public');
        }])->limit(8)->get();

        $stats = [
            'prompts' => Prompt::where('status', 'public')->count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
        ];

        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];

        return view('home', compact('featuredPrompts', 'categories', 'stats', 'platforms'));
    }
}

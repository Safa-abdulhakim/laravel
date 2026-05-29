<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Prompt;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['prompts' => function($q) {
            $q->where('status', 'public');
        }])->get();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $prompts = Prompt::with(['user', 'category', 'tags'])
            ->where('category_id', $category->id)
            ->where('status', 'public')
            ->latest()
            ->paginate(12);
        return view('categories.show', compact('category', 'prompts'));
    }
}

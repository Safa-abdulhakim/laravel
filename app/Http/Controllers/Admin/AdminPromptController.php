<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePromptRequest;
use App\Http\Requests\UpdatePromptRequest;
use Illuminate\Http\Request;

class AdminPromptController extends Controller
{
    public function index(Request $request)
    {
        $query = Prompt::with(['user', 'category', 'tags']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('prompt_content', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->platform) $query->where('platform', $request->platform);
        if ($request->category) $query->where('category_id', $request->category);

        $prompts = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];
        return view('admin.prompts.index', compact('prompts', 'categories', 'platforms'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];
        return view('admin.prompts.create', compact('categories', 'tags', 'platforms'));
    }

    public function store(StorePromptRequest $request)
    {
        $prompt = Prompt::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id(), 'favorite' => $request->boolean('favorite')]
        ));
        if ($request->tags) $prompt->tags()->sync($request->tags);
        return redirect()->route('admin.prompts.index')->with('success', 'Prompt created!');
    }

    public function edit(Prompt $prompt)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];
        $prompt->load('tags');
        return view('admin.prompts.edit', compact('prompt', 'categories', 'tags', 'platforms'));
    }

    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {
        $prompt->update(array_merge(
            $request->validated(),
            ['favorite' => $request->boolean('favorite')]
        ));
        $prompt->tags()->sync($request->tags ?? []);
        return redirect()->route('admin.prompts.index')->with('success', 'Prompt updated!');
    }

    public function destroy(Prompt $prompt)
    {
        $prompt->delete();
        return redirect()->route('admin.prompts.index')->with('success', 'Prompt deleted!');
    }
}

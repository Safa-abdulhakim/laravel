<?php
namespace App\Http\Controllers;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePromptRequest;
use App\Http\Requests\UpdatePromptRequest;
use Illuminate\Http\Request;

class PromptController extends Controller
{
    // Public listing
    public function index(Request $request)
    {
        $query = Prompt::with(['user', 'category', 'tags'])
            ->where('status', 'public');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('prompt_content', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->platform) {
            $query->where('platform', $request->platform);
        }

        if ($request->tag) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $prompts = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::all();
        $tags = Tag::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];

        return view('prompts.index', compact('prompts', 'categories', 'tags', 'platforms'));
    }

    // Public show
    public function show(Prompt $prompt)
    {
        if ($prompt->status === 'private' && auth()->id() !== $prompt->user_id) {
            abort(403);
        }
        $prompt->increment('views');
        $prompt->load(['user', 'category', 'tags']);
        $related = Prompt::where('status', 'public')
            ->where('category_id', $prompt->category_id)
            ->where('id', '!=', $prompt->id)
            ->limit(4)->get();
        $isFavorited = auth()->check() && auth()->user()->favorites()->where('prompt_id', $prompt->id)->exists();
        return view('prompts.show', compact('prompt', 'related', 'isFavorited'));
    }

    // User: My Prompts listing
    public function myIndex(Request $request)
    {
        $query = Prompt::with(['category', 'tags'])
            ->where('user_id', auth()->id());

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('prompt_content', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $prompts = $query->latest()->paginate(10)->withQueryString();
        return view('dashboard.prompts.index', compact('prompts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];
        return view('dashboard.prompts.create', compact('categories', 'tags', 'platforms'));
    }

    public function store(StorePromptRequest $request)
    {
        $prompt = Prompt::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id(), 'favorite' => $request->boolean('favorite')]
        ));

        if ($request->tags) {
            $prompt->tags()->sync($request->tags);
        }

        return redirect()->route('my-prompts.index')->with('success', 'Prompt created successfully!');
    }

    public function edit(Prompt $prompt)
    {
        if (auth()->id() !== $prompt->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $categories = Category::all();
        $tags = Tag::all();
        $platforms = ['ChatGPT', 'Claude', 'Gemini', 'Midjourney', 'Other'];
        $prompt->load('tags');
        return view('dashboard.prompts.edit', compact('prompt', 'categories', 'tags', 'platforms'));
    }

    public function update(UpdatePromptRequest $request, Prompt $prompt)
    {
        if (auth()->id() !== $prompt->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $prompt->update(array_merge(
            $request->validated(),
            ['favorite' => $request->boolean('favorite')]
        ));
        $prompt->tags()->sync($request->tags ?? []);
        return redirect()->route('my-prompts.index')->with('success', 'Prompt updated successfully!');
    }

    public function destroy(Prompt $prompt)
    {
        if (auth()->id() !== $prompt->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $prompt->delete();
        return redirect()->back()->with('success', 'Prompt deleted successfully!');
    }
}

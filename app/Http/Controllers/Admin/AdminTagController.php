<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use Illuminate\Support\Str;

class AdminTagController extends Controller
{
    public function index()
    {
        $tags = Tag::withCount('prompts')->latest()->paginate(20);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request)
    {
        Tag::create(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag created!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(StoreTagRequest $request, Tag $tag)
    {
        $tag->update(['name' => $request->name, 'slug' => Str::slug($request->name)]);
        return redirect()->route('admin.tags.index')->with('success', 'Tag updated!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted!');
    }
}

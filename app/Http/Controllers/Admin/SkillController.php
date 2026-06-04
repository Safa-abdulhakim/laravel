<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('sort_order')->get();
        $skillsByCategory = $skills->groupBy('category');
        return view('dashboard.skills.index', compact('skills', 'skillsByCategory'));
    }

    public function create()
    {
        return view('dashboard.skills.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'category' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'integer',
        ]);
        Skill::create($data);
        return redirect()->route('admin.skills.index')->with('success', __('messages.created_success'));
    }

    public function edit(Skill $skill)
    {
        return view('dashboard.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'category' => 'required|string',
            'icon' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'sort_order' => 'integer',
        ]);
        $skill->update($data);
        return redirect()->route('admin.skills.index')->with('success', __('messages.updated_success'));
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', __('messages.deleted_success'));
    }
}

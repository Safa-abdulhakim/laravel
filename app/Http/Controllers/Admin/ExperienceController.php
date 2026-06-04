<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderByDesc('start_date')->paginate(15);
        return view('dashboard.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('dashboard.experiences.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_name_ar' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'position_ar' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:1024',
            'sort_order' => 'integer',
        ]);
        $data['is_current'] = $request->boolean('is_current');
        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')->store('experiences', 'public');
        }
        Experience::create($data);
        return redirect()->route('admin.experiences.index')->with('success', __('messages.created_success'));
    }

    public function edit(Experience $experience)
    {
        return view('dashboard.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_name_ar' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'position_ar' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'company_logo' => 'nullable|image|max:1024',
            'sort_order' => 'integer',
        ]);
        $data['is_current'] = $request->boolean('is_current');
        if ($request->hasFile('company_logo')) {
            if ($experience->company_logo) Storage::disk('public')->delete($experience->company_logo);
            $data['company_logo'] = $request->file('company_logo')->store('experiences', 'public');
        }
        $experience->update($data);
        return redirect()->route('admin.experiences.index')->with('success', __('messages.updated_success'));
    }

    public function destroy(Experience $experience)
    {
        if ($experience->company_logo) Storage::disk('public')->delete($experience->company_logo);
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', __('messages.deleted_success'));
    }
}

<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->paginate(15);
        return view('dashboard.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('dashboard.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'position_ar' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'content_ar' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
            'avatar' => 'nullable|image|max:1024',
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }
        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', __('messages.created_success'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('dashboard.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'position_ar' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'content_ar' => 'nullable|string',
            'rating' => 'integer|min:1|max:5',
            'is_visible' => 'boolean',
            'sort_order' => 'integer',
            'avatar' => 'nullable|image|max:1024',
        ]);
        $data['is_visible'] = $request->boolean('is_visible');
        if ($request->hasFile('avatar')) {
            if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }
        $testimonial->update($data);
        return redirect()->route('admin.testimonials.index')->with('success', __('messages.updated_success'));
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->avatar) Storage::disk('public')->delete($testimonial->avatar);
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', __('messages.deleted_success'));
    }
}

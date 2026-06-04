<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CVController extends Controller
{
    public function index()
    {
        $cvs = CV::latest()->paginate(10);
        $activeCv = CV::where('is_active', true)->latest()->first();
        return view('dashboard.cv.index', compact('cvs', 'activeCv'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf|max:5120',
        ]);

        CV::where('is_active', true)->update(['is_active' => false]);

        $file = $request->file('cv_file');
        $path = $file->store('cvs', 'public');

        CV::create([
            'file_path' => $path,
            'file_name' => $file->getClientOriginalName(),
            'is_active' => true,
        ]);

        return redirect()->route('admin.cv.index')->with('success', __('messages.cv_uploaded'));
    }

    public function destroy(CV $cv)
    {
        Storage::disk('public')->delete($cv->file_path);
        $cv->delete();
        return redirect()->route('admin.cv.index')->with('success', __('messages.deleted_success'));
    }
}

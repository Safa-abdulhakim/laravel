<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CvRequest;
use App\Models\Cv;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function index()
    {
        $cvs = Cv::latest()->paginate(10);
        $activeCv = Cv::where('is_active', true)->latest()->first();
        return view('admin.cv.index', compact('cvs', 'activeCv'));
    }

    public function store(CvRequest $request)
    {
        $file = $request->file('cv_file');
        $path = $file->store('cv', 'public');

        // Deactivate all existing CVs
        Cv::where('is_active', true)->update(['is_active' => false]);

        Cv::create([
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'file_size' => $this->formatFileSize($file->getSize()),
            'is_active' => true,
        ]);

        return redirect()->route('admin.cv.index')
            ->with('success', 'CV uploaded successfully!');
    }

    public function activate(Cv $cv)
    {
        Cv::where('is_active', true)->update(['is_active' => false]);
        $cv->update(['is_active' => true]);
        return back()->with('success', 'CV activated successfully!');
    }

    public function destroy(Cv $cv)
    {
        Storage::disk('public')->delete($cv->file_path);
        $cv->delete();
        return redirect()->route('admin.cv.index')
            ->with('success', 'CV deleted successfully!');
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        return number_format($bytes / 1024, 2) . ' KB';
    }
}

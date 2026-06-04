<?php
namespace App\Http\Controllers;
use App\Models\CV;
use Illuminate\Support\Facades\Storage;

class CVController extends Controller
{
    public function download()
    {
        $cv = CV::where('is_active', true)->latest()->first();
        if (!$cv) {
            return redirect()->back()->with('error', __('messages.cv_not_found'));
        }
        return Storage::download($cv->file_path, $cv->file_name);
    }
}

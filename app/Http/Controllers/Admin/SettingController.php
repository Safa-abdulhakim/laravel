<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('dashboard.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'nullable|string|max:255',
            'full_name_ar' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'job_title_ar' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'bio_ar' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'github_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'years_experience' => 'nullable|integer',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('settings', 'public');
            Setting::set('avatar', $path);
            unset($data['avatar']);
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', __('messages.settings_saved'));
    }
}

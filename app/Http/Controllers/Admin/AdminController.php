<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_prompts' => Prompt::count(),
            'public_prompts' => Prompt::where('status', 'public')->count(),
            'total_categories' => Category::count(),
            'total_tags' => Tag::count(),
            'total_views' => Prompt::sum('views'),
        ];

        $recentPrompts = Prompt::with(['user', 'category'])->latest()->limit(10)->get();
        $recentUsers = User::latest()->limit(5)->get();

        $platformData = Prompt::selectRaw('platform, count(*) as count')
            ->groupBy('platform')
            ->pluck('count', 'platform');

        $monthlyData = Prompt::selectRaw("strftime('%Y-%m', created_at) as month, count(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->pluck('count', 'month');

        return view('admin.dashboard', compact('stats', 'recentPrompts', 'recentUsers', 'platformData', 'monthlyData'));
    }
}

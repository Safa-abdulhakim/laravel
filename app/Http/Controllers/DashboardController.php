<?php
namespace App\Http\Controllers;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Tag;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $stats = [
            'total_prompts' => Prompt::where('user_id', $user->id)->count(),
            'public_prompts' => Prompt::where('user_id', $user->id)->where('status', 'public')->count(),
            'private_prompts' => Prompt::where('user_id', $user->id)->where('status', 'private')->count(),
            'favorites' => $user->favorites()->count(),
            'total_views' => Prompt::where('user_id', $user->id)->sum('views'),
        ];

        $recentPrompts = Prompt::where('user_id', $user->id)
            ->with(['category', 'tags'])
            ->latest()
            ->limit(5)
            ->get();

        $platformData = Prompt::where('user_id', $user->id)
            ->selectRaw('platform, count(*) as count')
            ->groupBy('platform')
            ->pluck('count', 'platform');

        return view('dashboard.index', compact('stats', 'recentPrompts', 'platformData'));
    }
}

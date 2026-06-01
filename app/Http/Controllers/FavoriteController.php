<?php
namespace App\Http\Controllers;
use App\Models\Prompt;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $prompts = auth()->user()->favorites()
            ->with(['category', 'tags', 'user'])
            ->latest('favorites.created_at')
            ->paginate(12);
        return view('dashboard.favorites.index', compact('prompts'));
    }

    public function toggle(Prompt $prompt)
    {
        $user = auth()->user();
        if ($user->favorites()->where('prompt_id', $prompt->id)->exists()) {
            $user->favorites()->detach($prompt->id);
            $favorited = false;
        } else {
            $user->favorites()->attach($prompt->id);
            $favorited = true;
        }

        if (request()->wantsJson()) {
            return response()->json(['favorited' => $favorited]);
        }

        return redirect()->back()->with('success', $favorited ? __('success_added_fav') : __('success_removed_fav'));
    }
}

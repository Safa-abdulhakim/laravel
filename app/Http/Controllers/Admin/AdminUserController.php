<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('prompts');
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        $users = $query->latest()->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('prompts');
        return view('admin.users.show', compact('user'));
    }

    public function toggleRole(User $user)
    {
        $user->update(['role' => $user->role === 'admin' ? 'user' : 'admin']);
        return redirect()->back()->with('success', 'User role updated!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Cannot delete your own account!');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted!');
    }
}

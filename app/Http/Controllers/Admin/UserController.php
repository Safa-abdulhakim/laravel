<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }
        $users = $query->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['userAchievements.achievement', 'userAchievements.careerPath']);
        $enrolledPaths = $user->getEnrolledCareerPaths();
        return view('admin.users.show', compact('user', 'enrolledPaths'));
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function toggleRole(User $user)
    {
        $user->update(['role' => $user->isAdmin() ? 'user' : 'admin']);
        return back()->with('success', 'User role updated successfully!');
    }
}

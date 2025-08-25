<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::count(),
            'posts' => \App\Models\Post::count(),
            'comments' => \App\Models\Comment::count(),
            'admins' => Admin::count()
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentAdmins = Admin::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentAdmins'));
    }

    public function manageAdmins()
    {
        // Get admins with pagination
        $admins = Admin::with('user')
            ->withCount('user') // Count user relation to ensure it exists
            ->latest()
            ->paginate(20);

        // Get users who are not admins
        $users = User::whereDoesntHave('admin')->get();

        // Calculate statistics
        $superAdminsCount = Admin::where('role', 'super_admin')->count();
        $regularAdminsCount = Admin::where('role', 'admin')->count();
        $activeAdminsCount = Admin::count(); // All admins are considered active
        $totalAdmins = $admins->total();

        return view('admin.admins.index', compact(
            'admins',
            'users',
            'superAdminsCount',
            'regularAdminsCount',
            'activeAdminsCount',
            'totalAdmins'
        ));
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:admins,user_id',
            'role' => 'required|in:admin,super_admin',
            'permissions' => 'nullable|array'
        ]);

        Admin::create([
            'user_id' => $request->user_id,
            'role' => $request->role,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully');
    }

    public function updateAdmin(Request $request, Admin $admin)
    {
        $request->validate([
            'role' => 'required|in:admin,super_admin',
            'permissions' => 'nullable|array'
        ]);

        $admin->update([
            'role' => $request->role,
            'permissions' => $request->permissions ?? []
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully');
    }

    public function deleteAdmin(Admin $admin)
    {
        if ($admin->role === 'super_admin' && Admin::where('role', 'super_admin')->count() <= 1) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Cannot delete the only super admin');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully');
    }
}

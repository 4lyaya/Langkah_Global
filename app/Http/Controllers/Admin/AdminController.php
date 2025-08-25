<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Basic statistics
        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'comments' => Comment::count(),
            'admins' => Admin::count(),
            // 'active_users' => User::where('last_login_at', '>=', now()->subDays(30))->count(),
            'new_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Recent activity
        $recentUsers = User::withCount(['posts', 'followers'])->latest()->take(5)->get();
        $recentAdmins = Admin::with('user')->latest()->take(5)->get();

        // Popular posts
        $popularPosts = Post::withCount(['likes', 'comments'])
            ->with('user')
            ->orderBy('likes_count', 'desc')
            ->take(5)
            ->get();

        // System health metrics
        $systemHealth = [
            'avg_posts_per_user' => User::count() > 0 ? Post::count() / User::count() : 0,
            'avg_comments_per_post' => Post::count() > 0 ? Comment::count() / Post::count() : 0,
            'engagement_rate' => User::count() > 0 ?
                (Post::count() + Comment::count()) / User::count() : 0,
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentAdmins',
            'popularPosts',
            'systemHealth'
        ));
    }

    public function manageAdmins(Request $request)
    {
        // Search functionality
        $query = Admin::with(['user' => function ($q) {
            $q->withCount(['posts', 'followers', 'following']);
        }]);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get admins with pagination
        $admins = $query->latest()->paginate(20);

        // Get users who are not admins for the add modal
        $users = User::whereDoesntHave('admin')
            ->orderBy('name')
            ->get(['id', 'name', 'username', 'email']);

        // Calculate statistics
        $superAdminsCount = Admin::where('role', 'super_admin')->count();
        $regularAdminsCount = Admin::where('role', 'admin')->count();
        $activeAdminsCount = Admin::count();
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
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('admins', 'user_id')->whereNull('deleted_at')
            ],
            'role' => 'required|in:admin,super_admin',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:manage_users,manage_posts,manage_comments,manage_settings'
        ]);

        // Check if user exists and is not already an admin
        $user = User::findOrFail($request->user_id);

        if ($user->isAdmin()) {
            return redirect()->back()
                ->with('error', __('This user is already an administrator.'))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $admin = Admin::create([
                'user_id' => $request->user_id,
                'role' => $request->role,
                'permissions' => $request->role === 'super_admin' ? null : ($request->permissions ?? [])
            ]);

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success', __('Admin created successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Failed to create admin. Please try again.'))
                ->withInput();
        }
    }

    public function updateAdmin(Request $request, Admin $admin)
    {
        $request->validate([
            'role' => 'required|in:admin,super_admin',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:manage_users,manage_posts,manage_comments,manage_settings'
        ]);

        // Prevent demoting the only super admin
        if (
            $admin->role === 'super_admin' &&
            $request->role === 'admin' &&
            Admin::where('role', 'super_admin')->count() <= 1
        ) {
            return redirect()->back()
                ->with('error', __('Cannot demote the only super admin.'))
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'role' => $request->role,
                'permissions' => $request->role === 'super_admin' ? null : ($request->permissions ?? [])
            ];

            $admin->update($updateData);

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success', __('Admin updated successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', __('Failed to update admin. Please try again.'))
                ->withInput();
        }
    }

    public function deleteAdmin(Admin $admin)
    {
        // Prevent deleting the only super admin
        if ($admin->role === 'super_admin' && Admin::where('role', 'super_admin')->count() <= 1) {
            return redirect()->route('admin.admins.index')
                ->with('error', __('Cannot delete the only super admin.'));
        }

        // Prevent users from deleting themselves
        if ($admin->user_id === auth()->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', __('You cannot delete your own admin account.'));
        }

        try {
            DB::beginTransaction();

            $admin->delete();

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success', __('Admin deleted successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.admins.index')
                ->with('error', __('Failed to delete admin. Please try again.'));
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,change_role',
            'admins' => 'required|array',
            'admins.*' => 'exists:admins,id',
            'new_role' => 'required_if:action,change_role|in:admin,super_admin'
        ]);

        $admins = Admin::whereIn('id', $request->admins)->get();

        try {
            DB::beginTransaction();

            foreach ($admins as $admin) {
                // Skip if trying to modify the only super admin
                if (
                    $admin->role === 'super_admin' &&
                    Admin::where('role', 'super_admin')->count() <= 1
                ) {
                    continue;
                }

                // Skip if trying to modify own account
                if ($admin->user_id === auth()->id()) {
                    continue;
                }

                if ($request->action === 'delete') {
                    $admin->delete();
                } elseif ($request->action === 'change_role') {
                    $admin->update(['role' => $request->new_role]);
                }
            }

            DB::commit();

            return redirect()->route('admin.admins.index')
                ->with('success', __('Bulk action completed successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.admins.index')
                ->with('error', __('Failed to perform bulk action. Please try again.'));
        }
    }

    public function getAdminStats()
    {
        // Additional statistics for AJAX requests or API
        $stats = [
            'total_admins' => Admin::count(),
            'super_admins' => Admin::where('role', 'super_admin')->count(),
            'regular_admins' => Admin::where('role', 'admin')->count(),
            'recently_added' => Admin::with('user')
                ->where('created_at', '>=', now()->subDays(7))
                ->count(),
            'permissions_distribution' => [
                'manage_users' => Admin::whereJsonContains('permissions', 'manage_users')->count(),
                'manage_posts' => Admin::whereJsonContains('permissions', 'manage_posts')->count(),
                'manage_comments' => Admin::whereJsonContains('permissions', 'manage_comments')->count(),
                'manage_settings' => Admin::whereJsonContains('permissions', 'manage_settings')->count(),
            ]
        ];

        return response()->json($stats);
    }
}

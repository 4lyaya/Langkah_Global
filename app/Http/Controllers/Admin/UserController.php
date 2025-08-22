<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount(['posts', 'followers', 'following']);

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('username', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->loadCount(['posts', 'followers', 'following']);
        $posts = $user->posts()->latest()->paginate(10);

        return view('admin.users.show', compact('user', 'posts'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'is_private' => 'boolean',
            'dark_mode' => 'boolean'
        ]);

        $user->update($request->only([
            'name',
            'username',
            'email',
            'phone',
            'bio',
            'website',
            'is_private',
            'dark_mode'
        ]));

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Cannot delete admin user. Remove admin privileges first.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }

    public function impersonate(User $user)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Only super admins can impersonate users');
        }

        session()->put('impersonate', $user->id);

        return redirect()->route('timeline')
            ->with('success', 'Now impersonating ' . $user->name);
    }

    public function stopImpersonate()
    {
        session()->forget('impersonate');

        return redirect()->route('admin.dashboard')
            ->with('success', 'Stopped impersonating');
    }
}
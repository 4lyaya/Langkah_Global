<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        if (!$user->canViewProfile(auth()->user())) {
            abort(403, 'This profile is private');
        }

        $posts = $user->posts()
            ->when(!$user->is(auth()->user()), function ($query) {
                $query->public();
            })
            ->latest()
            ->paginate(12);

        $isFollowing = auth()->user()->follows($user);

        return view('profile.show', compact('user', 'posts', 'isFollowing'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

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
            'birthdate' => 'nullable|date|before:today',
            'bio' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|image|max:2048',
            'language' => 'required|in:en,id,zh',
            'is_private' => 'boolean',
            'dark_mode' => 'boolean'
        ]);

        $updateData = $request->only([
            'name',
            'username',
            'email',
            'phone',
            'birthdate',
            'bio',
            'website',
            'language',
            'is_private',
            'dark_mode'
        ]);

        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $updateData['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $user->update($updateData);

        return redirect()->route('profile.show', $user)
            ->with('success', 'Profile updated successfully');
    }

    public function follow(User $user)
    {
        if (auth()->user()->is($user)) {
            return back()->with('error', 'You cannot follow yourself');
        }

        if (!$user->is_private || $user->followers()->where('follower_id', auth()->id())->exists()) {
            auth()->user()->following()->syncWithoutDetaching([$user->id]);

            // Notify the user
            $user->notifications()->create([
                'type' => 'new_follower',
                'data' => [
                    'message' => __(':username started following you', ['username' => auth()->user()->username]),
                    'follower_id' => auth()->id()
                ]
            ]);

            return back()->with('success', __('messages.followed', ['username' => $user->username]));
        }

        // For private accounts, send follow request instead
        // This would require additional logic for follow requests
        return back()->with('info', 'Follow request sent');
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->id);

        return back()->with('success', __('messages.unfollowed', ['username' => $user->username]));
    }

    public function followers(User $user)
    {
        if (!$user->canViewProfile(auth()->user())) {
            abort(403, 'This profile is private');
        }

        $followers = $user->followers()->paginate(20);

        return view('profile.followers', compact('user', 'followers'));
    }

    public function following(User $user)
    {
        if (!$user->canViewProfile(auth()->user())) {
            abort(403, 'This profile is private');
        }

        $following = $user->following()->paginate(20);

        return view('profile.following', compact('user', 'following'));
    }
}
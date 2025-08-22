<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserObserver
{
    public function deleting(User $user)
    {
        // Delete all user content when account is deleted
        $user->posts()->delete();
        $user->comments()->delete();
        $user->likes()->delete();
        $user->notifications()->delete();

        // Remove from follows
        $user->followers()->detach();
        $user->following()->detach();

        // Delete admin record if exists
        if ($user->admin) {
            $user->admin()->delete();
        }

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }
    }
}
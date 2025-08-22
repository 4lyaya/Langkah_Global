<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function view(User $user, Post $post)
    {
        if ($post->is_public) {
            return true;
        }

        return $post->user_id === $user->id || $post->user->followers()->where('follower_id', $user->id)->exists();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return $post->user_id === $user->id;
    }

    public function delete(User $user, Post $post)
    {
        return $post->user_id === $user->id || $user->isAdmin();
    }

    public function like(User $user, Post $post)
    {
        return $this->view($user, $post) && !$post->isLikedBy($user);
    }

    public function unlike(User $user, Post $post)
    {
        return $post->isLikedBy($user);
    }
}
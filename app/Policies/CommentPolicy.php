<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    public function view(User $user, Comment $comment)
    {
        return $comment->post->is_public ||
            $comment->post->user_id === $user->id ||
            $comment->post->user->followers()->where('follower_id', $user->id)->exists();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }

    public function delete(User $user, Comment $comment)
    {
        return $comment->user_id === $user->id ||
            $comment->post->user_id === $user->id ||
            $user->isAdmin();
    }

    public function like(User $user, Comment $comment)
    {
        return $this->view($user, $comment) && !$comment->isLikedBy($user);
    }

    public function unlike(User $user, Comment $comment)
    {
        return $comment->isLikedBy($user);
    }
}
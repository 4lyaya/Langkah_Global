<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Storage;

class CommentObserver
{
    public function deleting(Comment $comment)
    {
        // Delete associated replies and likes
        $comment->replies()->delete();
        $comment->likes()->delete();

        // Delete image file if exists
        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }
    }
}
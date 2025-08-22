<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    public function deleting(Post $post)
    {
        // Delete associated comments and likes
        $post->comments()->delete();
        $post->likes()->delete();

        // Delete image file if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
    }
}
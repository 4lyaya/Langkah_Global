<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required_without:image|string|max:500|nullable',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $commentData = [
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ];

        if ($request->hasFile('image')) {
            $commentData['image'] = $request->file('image')->store('comments', 'public');
        }

        $comment = Comment::create($commentData);

        // Notify post owner if it's not their comment
        if ($post->user_id !== auth()->id()) {
            $post->user->notifications()->create([
                'type' => 'new_comment',
                'data' => [
                    'message' => __(':username commented on your post', ['username' => auth()->user()->username]),
                    'post_id' => $post->id,
                    'comment_id' => $comment->id
                ]
            ]);
        }

        // Notify parent comment owner if it's a reply
        if ($request->parent_id && $comment->parent->user_id !== auth()->id()) {
            $comment->parent->user->notifications()->create([
                'type' => 'comment_reply',
                'data' => [
                    'message' => __(':username replied to your comment', ['username' => auth()->user()->username]),
                    'post_id' => $post->id,
                    'comment_id' => $comment->id
                ]
            ]);
        }

        return back()->with('success', __('messages.comment_added'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required_without:image|string|max:500|nullable',
            'image' => 'nullable|image|max:2048'
        ]);

        $updateData = ['content' => $request->content];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($comment->image) {
                Storage::disk('public')->delete($comment->image);
            }
            $updateData['image'] = $request->file('image')->store('comments', 'public');
        } elseif ($request->has('remove_image') && $comment->image) {
            Storage::disk('public')->delete($comment->image);
            $updateData['image'] = null;
        }

        $comment->update($updateData);

        return back()->with('success', 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        if ($comment->image) {
            Storage::disk('public')->delete($comment->image);
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }

    public function like(Comment $comment)
    {
        $like = $comment->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);

        if ($like->wasRecentlyCreated && $comment->user_id !== auth()->id()) {
            $comment->user->notifications()->create([
                'type' => 'comment_like',
                'data' => [
                    'message' => __(':username liked your comment', ['username' => auth()->user()->username]),
                    'post_id' => $comment->post_id,
                    'comment_id' => $comment->id
                ]
            ]);
        }

        return response()->json(['liked' => true, 'likes_count' => $comment->likes()->count()]);
    }

    public function unlike(Comment $comment)
    {
        $comment->likes()->where('user_id', auth()->id())->delete();

        return response()->json(['liked' => false, 'likes_count' => $comment->likes()->count()]);
    }
}
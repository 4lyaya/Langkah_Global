<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $followingIds = auth()->user()
            ->following()
            ->pluck('users.id as user_id')
            ->push(auth()->id());

        $posts = Post::with(['user', 'likes', 'comments.user'])
            ->whereIn('user_id', $followingIds)
            ->orWhere('is_public', true)
            ->latest()
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('posts.partials.posts', compact('posts'))->render(),
                'next_page' => $posts->nextPageUrl()
            ]);
        }

        return view('timeline.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required_without:image|string|max:500|nullable',
            'image' => 'nullable|image|max:2048',
            'is_public' => 'boolean'
        ]);

        $postData = [
            'user_id' => auth()->id(),
            'content' => $request->content,
            'is_public' => $request->is_public ?? true
        ];

        if ($request->hasFile('image')) {
            $postData['image'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($postData);

        // Notify followers
        $this->notifyFollowers($post);

        return back()->with('success', __('messages.post_created'));
    }

    public function show(Post $post)
    {
        if (
            !$post->is_public && $post->user_id !== auth()->id() &&
            !$post->user->followers()->where('follower_id', auth()->id())->exists()
        ) {
            abort(403, 'This post is private');
        }

        $post->load(['user', 'comments.user', 'likes.user']);

        return view('posts.show', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required_without:image|string|max:500|nullable',
            'image' => 'nullable|image|max:2048',
            'is_public' => 'boolean'
        ]);

        $updateData = [
            'content' => $request->content,
            'is_public' => $request->is_public ?? $post->is_public
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $updateData['image'] = $request->file('image')->store('posts', 'public');
        } elseif ($request->has('remove_image') && $post->image) {
            Storage::disk('public')->delete($post->image);
            $updateData['image'] = null;
        }

        $post->update($updateData);

        return back()->with('success', __('messages.post_updated'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', __('messages.post_deleted'));
    }

    public function like(Post $post)
    {
        $like = $post->likes()->firstOrCreate([
            'user_id' => auth()->id()
        ]);

        if ($like->wasRecentlyCreated && $post->user_id !== auth()->id()) {
            $post->user->notifications()->create([
                'type' => 'post_like',
                'data' => [
                    'message' => __(':username liked your post', ['username' => auth()->user()->username]),
                    'post_id' => $post->id
                ]
            ]);
        }

        // Redirect ke route 'timeline' setelah like
        return redirect()->route('timeline')->with('success', 'Post berhasil di-like!');
    }

    public function unlike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return response()->json(['liked' => false, 'likes_count' => $post->likes()->count()]);
    }

    private function notifyFollowers($post)
    {
        $followers = auth()->user()->followers;

        foreach ($followers as $follower) {
            $follower->notifications()->create([
                'type' => 'new_post',
                'data' => [
                    'message' => __(':username posted something new', ['username' => auth()->user()->username]),
                    'post_id' => $post->id
                ]
            ]);
        }
    }
}
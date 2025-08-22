<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'likes', 'comments']);

        if ($request->has('search')) {
            $query->where('content', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('username', 'like', '%' . $request->search . '%');
                });
        }

        $posts = $query->latest()->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes.user']);

        return view('admin.posts.show', compact('post'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'posts' => 'required|array'
        ]);

        if ($request->action === 'delete') {
            Post::whereIn('id', $request->posts)->delete();
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bulk action completed successfully');
    }
}
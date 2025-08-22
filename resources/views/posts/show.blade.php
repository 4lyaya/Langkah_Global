@extends('layouts.app')

@section('title', __('Post by :name', ['name' => $post->user->name]))

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Post -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                        class="w-10 h-10 rounded-full">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span x-data="{ tooltip: false }" @mouseover="tooltip = true" @mouseleave="tooltip = false"
                                class="relative">
                                <time
                                    datetime="{{ $post->created_at->toISOString() }}">{{ $post->created_at->diffForHumans() }}</time>
                                <span x-show="tooltip"
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs text-white bg-gray-900 rounded-lg whitespace-nowrap">
                                    {{ $post->created_at->format('M j, Y \a\t g:i A') }}
                                </span>
                            </span>
                        </p>
                    </div>
                </div>

                @can('update', $post)
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                </path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                            <a href="{{ route('posts.edit', $post) }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan
            </div>

            <div class="mb-4">
                <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $post->content }}</p>
            </div>

            @if ($post->image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg">
                </div>
            @endif

            <div class="flex items-center justify-between text-gray-500 dark:text-gray-400">
                <div class="flex items-center space-x-4">
                    <form action="{{ route($post->isLikedBy(auth()->user()) ? 'posts.unlike' : 'posts.like', $post) }}"
                        method="POST">
                        @csrf
                        @if ($post->isLikedBy(auth()->user()))
                            @method('DELETE')
                        @endif
                        <button type="submit" class="flex items-center space-x-1 text-red-500 hover:text-red-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span>{{ $post->likesCount() }}</span>
                        </button>
                    </form>

                    <button class="flex items-center space-x-1 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <span>{{ $post->commentsCount() }}</span>
                    </button>
                </div>

                @if (!$post->is_public)
                    <span class="text-sm text-gray-400 dark:text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        {{ __('Private') }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Comments -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">{{ __('Comments') }}</h3>

            <!-- Comment Form -->
            <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-6">
                @csrf
                <div class="flex space-x-3">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                        class="w-8 h-8 rounded-full">
                    <div class="flex-1">
                        <textarea name="content" rows="2" placeholder="{{ __('Write a comment...') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg resize-none focus:border-primary-500 focus:ring-primary-500"></textarea>
                        <div class="flex justify-between items-center mt-2">
                            <label for="comment_image"
                                class="cursor-pointer text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <input type="file" name="image" id="comment_image" accept="image/*" class="hidden">
                            </label>
                            <button type="submit"
                                class="bg-primary-600 text-white px-4 py-1 rounded-lg text-sm hover:bg-primary-700">
                                {{ __('Comment') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($post->comments as $comment)
                    <div class="flex space-x-3">
                        <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}"
                            class="w-8 h-8 rounded-full">
                        <div class="flex-1">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white">
                                        {{ $comment->user->name }}</h4>
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-800 dark:text-gray-200 text-sm">{{ $comment->content }}</p>

                                @if ($comment->image)
                                    <img src="{{ asset('storage/' . $comment->image) }}" alt="Comment image"
                                        class="mt-2 rounded-lg max-w-xs">
                                @endif
                            </div>

                            <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500 dark:text-gray-400">
                                <form
                                    action="{{ route($comment->isLikedBy(auth()->user()) ? 'comments.unlike' : 'comments.like', $comment) }}"
                                    method="POST">
                                    @csrf
                                    @if ($comment->isLikedBy(auth()->user()))
                                        @method('DELETE')
                                    @endif
                                    <button type="submit"
                                        class="flex items-center space-x-1 hover:text-gray-700 dark:hover:text-gray-300">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{ $comment->likes->count() }}</span>
                                    </button>
                                </form>

                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600"
                                            onclick="return confirm('Are you sure you want to delete this comment?')">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center">{{ __('No comments yet.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', $user->name)

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-6">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">
                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->username }}</p>
                        </div>

                        @if (auth()->id() !== $user->id)
                            <form action="{{ route($isFollowing ? 'users.unfollow' : 'users.follow', $user) }}"
                                method="POST">
                                @csrf
                                @if ($isFollowing)
                                    @method('DELETE')
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg text-sm font-medium {{ $isFollowing ? 'bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200' : 'bg-primary-600 text-white hover:bg-primary-700' }}">
                                    {{ $isFollowing ? __('Following') : __('Follow') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('profile.edit') }}"
                                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                                {{ __('Edit Profile') }}
                            </a>
                        @endif
                    </div>

                    @if ($user->bio)
                        <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                    @endif

                    <div class="flex items-center space-x-6 mt-4 text-sm">
                        <a href="{{ route('profile.followers', $user) }}"
                            class="hover:text-primary-600 dark:hover:text-primary-400">
                            <span class="font-semibold">{{ $user->followers_count }}</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Followers') }}</span>
                        </a>
                        <a href="{{ route('profile.following', $user) }}"
                            class="hover:text-primary-600 dark:hover:text-primary-400">
                            <span class="font-semibold">{{ $user->following_count }}</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Following') }}</span>
                        </a>
                        <span>
                            <span class="font-semibold">{{ $user->posts_count }}</span>
                            <span class="text-gray-600 dark:text-gray-400">{{ __('Posts') }}</span>
                        </span>
                    </div>

                    @if ($user->website)
                        <div class="mt-3">
                            <a href="{{ $user->website }}" target="_blank"
                                class="text-primary-600 hover:text-primary-500 text-sm">
                                {{ parse_url($user->website, PHP_URL_HOST) }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    @if ($post->image)
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                                class="w-full h-48 object-cover">
                        </a>
                    @endif
                    <div class="p-4">
                        <p class="text-gray-800 dark:text-gray-200 line-clamp-3">{{ Str::limit($post->content, 100) }}</p>
                        <div class="flex items-center justify-between mt-3 text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                            <div class="flex items-center space-x-2">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $post->likes_count }}
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    {{ $post->comments_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">{{ __('No posts yet.') }}</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush

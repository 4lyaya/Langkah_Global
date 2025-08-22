<x-layouts.app>
    <x-slot name="title">{{ $user->name }}</x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center space-x-6">
                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full">

                <div class="flex-1">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            <p class="text-gray-500 dark:text-gray-400">@{{ $user - > username }}</p>
                        </div>

                        @if (auth()->user()->id !== $user->id)
                            <form action="{{ route($isFollowing ? 'users.unfollow' : 'users.follow', $user) }}"
                                method="POST">
                                @csrf
                                @if ($isFollowing)
                                    @method('DELETE')
                                @endif
                                <button type="submit"
                                    class="bg-{{ $isFollowing ? 'gray' : 'blue' }}-600 hover:bg-{{ $isFollowing ? 'gray' : 'blue' }}-700 text-white font-medium py-2 px-4 rounded-md">
                                    {{ $isFollowing ? __('Following') : __('Follow') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('profile.edit') }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md">
                                {{ __('Edit Profile') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center space-x-6 text-sm">
                        <span class="text-gray-600 dark:text-gray-400">
                            <strong class="text-gray-900 dark:text-white">{{ $user->posts_count }}</strong>
                            {{ __('posts') }}
                        </span>
                        <a href="{{ route('profile.followers', $user) }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            <strong class="text-gray-900 dark:text-white">{{ $user->followers_count }}</strong>
                            {{ __('followers') }}
                        </a>
                        <a href="{{ route('profile.following', $user) }}"
                            class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                            <strong class="text-gray-900 dark:text-white">{{ $user->following_count }}</strong>
                            {{ __('following') }}
                        </a>
                    </div>

                    @if ($user->bio)
                        <p class="mt-4 text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                    @endif

                    @if ($user->website)
                        <a href="{{ $user->website }}" target="_blank"
                            class="mt-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            {{ parse_url($user->website, PHP_URL_HOST) }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                            class="w-full h-48 object-cover">
                    @endif

                    <div class="p-4">
                        <p class="text-gray-700 dark:text-gray-300 line-clamp-3">{{ $post->content }}</p>

                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                            <span>{{ $post->created_at->diffForHumans() }}</span>

                            <div class="flex items-center space-x-4">
                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                    <span>{{ $post->likes_count }}</span>
                                </span>

                                <span class="flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    <span>{{ $post->comments_count }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('posts.show', $post) }}"
                        class="block bg-gray-50 dark:bg-gray-700 px-4 py-2 text-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ __('View Post') }}
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('No posts yet') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->id === auth()->id() ? __('Get started by creating your first post.') : __('This user hasn\'t posted anything yet.') }}
                    </p>
                    @if ($user->id === auth()->id())
                        <div class="mt-6">
                            <a href="{{ route('posts.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                {{ __('New Post') }}
                            </a>
                        </div>
                    @endif
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

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.app>

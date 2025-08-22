@foreach ($posts as $post)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6 post-item">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('profile.show', $post->user) }}">
                    <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                        class="w-10 h-10 rounded-full">
                </a>
                <div>
                    <a href="{{ route('profile.show', $post->user) }}"
                        class="font-semibold hover:text-blue-600 dark:hover:text-blue-400">{{ $post->user->name }}</a>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            @can('update', $post)
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                            </path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50">
                        <a href="{{ route('posts.edit', $post) }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('Edit') }}</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">{{ __('Delete') }}</button>
                        </form>
                    </div>
                </div>
            @endcan
        </div>

        <div class="mt-4">
            <p class="text-gray-900 dark:text-white">{{ $post->content }}</p>

            @if ($post->image)
                <div class="mt-4">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post image" class="w-full rounded-lg">
                </div>
            @endif
        </div>

        <div class="mt-4 flex items-center space-x-6 text-gray-500 dark:text-gray-400">
            <form action="{{ route($post->isLikedBy(auth()->user()) ? 'posts.unlike' : 'posts.like', $post) }}"
                method="POST" class="inline">
                @csrf
                @if ($post->isLikedBy(auth()->user()))
                    @method('DELETE')
                @endif
                <button type="submit" class="flex items-center space-x-1 hover:text-blue-600 dark:hover:text-blue-400">
                    <svg class="w-5 h-5 {{ $post->isLikedBy(auth()->user()) ? 'text-red-500 fill-current' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                    <span>{{ $post->likes_count }}</span>
                </button>
            </form>

            <a href="{{ route('posts.show', $post) }}"
                class="flex items-center space-x-1 hover:text-blue-600 dark:hover:text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <span>{{ $post->comments_count }}</span>
            </a>
        </div>
    </div>
@endforeach

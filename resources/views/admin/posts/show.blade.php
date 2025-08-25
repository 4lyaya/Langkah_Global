@extends('layouts.admin')

@section('admin-title', __('Post Details') . ' - #' . $post->id)

@section('admin-content')
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Post Details') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Post ID') }}: #{{ $post->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.posts.index') }}"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Posts') }}
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Post Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Post Information') }}</h3>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                            {{ $post->is_public ? __('Public') : __('Private') }}
                        </span>
                    </div>

                    <!-- Author Info -->
                    <div class="flex items-center space-x-3 mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                            class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->user->name }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">@{{ $post - > user - > username }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ __('User ID') }}:
                                #{{ $post->user->id }}</p>
                        </div>
                    </div>

                    <!-- Post Content -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Content') }}
                        </label>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <p class="text-gray-800 dark:text-gray-200 whitespace-pre-line">
                                {{ $post->content ?: __('No content') }}</p>
                        </div>
                    </div>

                    <!-- Post Image -->
                    @if ($post->image)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Image') }}
                            </label>
                            <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                                    class="w-full h-64 object-cover cursor-pointer" onclick="openModal('imageModal')">
                            </div>
                        </div>
                    @endif

                    <!-- Post Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $post->likes_count }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Likes') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                {{ $post->comments_count }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Comments') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $post->created_at->format('M j, Y') }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Created') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $post->updated_at->format('M j, Y') }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Updated') }}</div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-600">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Last updated') }}: {{ $post->updated_at->diffForHumans() }}
                        </div>
                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200 flex items-center"
                                onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                {{ __('Delete Post') }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Comments') }}
                            ({{ $post->comments_count }})</h3>
                    </div>

                    @if ($post->comments_count > 0)
                        <div class="space-y-4">
                            @foreach ($post->comments as $comment)
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $comment->user->profile_photo_url }}"
                                                alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $comment->user->name }}</h4>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:hover:text-red-400 text-xs"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this comment?') }}')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <p class="text-gray-800 dark:text-gray-200 text-sm mb-3">{{ $comment->content }}</p>

                                    @if ($comment->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $comment->image) }}" alt="Comment image"
                                                class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer"
                                                onclick="openModal('commentImageModal{{ $comment->id }}')">
                                        </div>
                                    @endif

                                    <div class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $comment->likes_count }}
                                        </span>
                                        @if ($comment->parent_id)
                                            <span
                                                class="bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 px-2 py-1 rounded-full">
                                                {{ __('Reply') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                            <p>{{ __('No comments yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Author Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Author Information') }}
                    </h3>

                    <div class="text-center mb-4">
                        <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                            class="w-20 h-20 rounded-full mx-auto mb-3">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $post->user->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">@{{ $post - > user - > username }}</p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Email') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $post->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Phone') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $post->user->phone ?: __('Not provided') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Joined') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $post->user->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Posts') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $post->user->posts_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Status') }}:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ __('Active') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                        <a href="{{ route('admin.users.show', $post->user) }}"
                            class="w-full bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-200 text-center block">
                            {{ __('View Full Profile') }}
                        </a>
                    </div>
                </div>

                <!-- Post Metadata -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Post Metadata') }}</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Post ID') }}:</span>
                            <span class="text-gray-900 dark:text-white">#{{ $post->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Created') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $post->created_at->format('M j, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Updated') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $post->updated_at->format('M j, Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Visibility') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $post->is_public ? __('Public') : __('Private') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Has Image') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $post->image ? __('Yes') : __('No') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Content Length') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ strlen($post->content) }}
                                {{ __('characters') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Quick Actions') }}</h3>

                    <div class="space-y-2">
                        <a href="{{ route('posts.show', $post) }}" target="_blank"
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                            <span>{{ __('View Public Post') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        <button onclick="togglePostVisibility({{ $post->id }})"
                            class="w-full flex items-center justify-between px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800/30 transition-colors duration-200">
                            <span>{{ $post->is_public ? __('Make Private') : __('Make Public') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>

                        <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-between px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-800/30 transition-colors duration-200"
                                onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')">
                                <span>{{ __('Delete Post') }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @if ($post->image)
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 max-w-4xl mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Post Image') }}</h3>
                    <button onclick="closeModal('imageModal')"
                        class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                    class="w-full h-auto max-h-96 object-contain">
            </div>
        </div>
    @endif

    <!-- Comment Image Modals -->
    @foreach ($post->comments as $comment)
        @if ($comment->image)
            <div id="commentImageModal{{ $comment->id }}"
                class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 max-w-4xl mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Comment Image') }}</h3>
                        <button onclick="closeModal('commentImageModal{{ $comment->id }}')"
                            class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <img src="{{ asset('storage/' . $comment->image) }}" alt="Comment image"
                        class="w-full h-auto max-h-96 object-contain">
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function togglePostVisibility(postId) {
            if (confirm('{{ __('Are you sure you want to change the visibility of this post?') }}')) {
                // Implement AJAX request to toggle visibility
                fetch(`/admin/posts/${postId}/toggle-visibility`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('{{ __('An error occurred while updating the post.') }}');
                    });
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modals = document.querySelectorAll('[id$="Modal"]');
                modals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });

        // Close modal on background click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                const modals = document.querySelectorAll('[id$="Modal"]');
                modals.forEach(modal => {
                    if (!modal.classList.contains('hidden')) {
                        closeModal(modal.id);
                    }
                });
            }
        });
    </script>

    <style>
        .hidden {
            display: none;
        }

        .fixed {
            display: flex;
        }
    </style>
@endpush

@extends('layouts.admin')

@section('admin-title', __('Posts Management'))

@section('admin-content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Posts Management') }}</h3>

                <!-- Search Form -->
                <form action="{{ route('admin.posts.index') }}" method="GET" class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search posts...') }}"
                            class="w-64 pl-10 pr-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700">
                        {{ __('Search') }}
                    </button>
                    @if (request()->has('search'))
                        <a href="{{ route('admin.posts.index') }}"
                            class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            {{ __('Clear') }}
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Bulk Actions -->
        @if ($posts->count() > 0)
            <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                <form id="bulk-action-form" action="{{ route('admin.posts.bulk-action') }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                        <select name="action"
                            class="border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">{{ __('Bulk Actions') }}</option>
                            <option value="delete">{{ __('Delete Selected') }}</option>
                        </select>
                        <button type="submit" id="bulk-action-btn"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            {{ __('Apply') }}
                        </button>
                        <span class="text-sm text-gray-500 dark:text-gray-400" id="selected-count">
                            0 {{ __('selected') }}
                        </span>
                    </div>
                </form>
            </div>
        @endif

        <!-- Posts Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-8">
                            <input type="checkbox" id="select-all"
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Post') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Author') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Stats') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Visibility') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Date') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <!-- Checkbox -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="posts[]" value="{{ $post->id }}"
                                    class="post-checkbox rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            </td>

                            <!-- Post Content -->
                            <td class="px-6 py-4">
                                <div class="flex items-start space-x-3">
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                                            class="w-12 h-12 rounded-lg object-cover flex-shrink-0">
                                    @else
                                        <div
                                            class="w-12 h-12 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-2">
                                            {{ $post->content ? Str::limit($post->content, 100) : __('No content') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            ID: {{ $post->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Author -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                                        class="w-8 h-8 rounded-full">
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $post->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            @{{ $post - > user - > username }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Stats -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-4 text-sm">
                                    <span class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $post->likes_count }}
                                    </span>
                                    <span class="flex items-center text-gray-600 dark:text-gray-400">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>
                                        {{ $post->comments_count }}
                                    </span>
                                </div>
                            </td>

                            <!-- Visibility -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $post->is_public ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                    @if ($post->is_public)
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        {{ __('Public') }}
                                    @else
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                        {{ __('Private') }}
                                    @endif
                                </span>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $post->created_at->format('M j, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $post->created_at->format('H:i') }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.posts.show', $post) }}"
                                        class="text-primary-600 hover:text-primary-900 dark:hover:text-primary-400"
                                        title="{{ __('View Post') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 dark:hover:text-red-400"
                                            onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')"
                                            title="{{ __('Delete Post') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">{{ __('No posts found') }}</p>
                                    <p class="text-sm">
                                        {{ __('Try adjusting your search criteria or create a new post.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .post-checkbox:checked {
            background-color: rgb(59 130 246 / var(--tw-bg-opacity));
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select all checkbox
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.post-checkbox');
            const bulkActionBtn = document.getElementById('bulk-action-btn');
            const selectedCount = document.getElementById('selected-count');
            const bulkActionForm = document.getElementById('bulk-action-form');

            // Update selected count
            function updateSelectedCount() {
                const selected = document.querySelectorAll('.post-checkbox:checked');
                selectedCount.textContent = `${selected.length} {{ __('selected') }}`;
                bulkActionBtn.disabled = selected.length === 0;
            }

            // Select all functionality
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateSelectedCount();
            });

            // Individual checkbox functionality
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Bulk action form submission
            bulkActionForm.addEventListener('submit', function(e) {
                const selected = document.querySelectorAll('.post-checkbox:checked');
                const action = this.querySelector('select[name="action"]').value;

                if (selected.length === 0 || !action) {
                    e.preventDefault();
                    return;
                }

                if (action === 'delete') {
                    if (!confirm('{{ __('Are you sure you want to delete the selected posts?') }}')) {
                        e.preventDefault();
                    }
                }
            });

            // Search functionality with debounce
            const searchInput = document.querySelector('input[name="search"]');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });
        });
    </script>
@endpush

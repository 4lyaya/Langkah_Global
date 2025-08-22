<x-layouts.admin>
    <x-slot name="title">{{ __('Posts Management') }}</x-slot>

    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ __('Posts Management') }}</h1>

        <form action="{{ route('admin.posts.index') }}" method="GET" class="flex items-center space-x-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search posts...') }}"
                class="border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                {{ __('Search') }}
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <input type="checkbox" id="select-all"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Content') }}</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Author') }}</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Likes') }}</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Comments') }}</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Created') }}</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($posts as $post)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="posts[]" value="{{ $post->id }}"
                                    class="post-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white max-w-xs truncate">
                                    {{ Str::limit($post->content, 50) }}</div>
                                @if ($post->image)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Has image') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                                        class="w-8 h-8 rounded-full mr-2">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $post->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $post->likes_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $post->comments_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $post->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.posts.show', $post) }}"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">{{ __('View') }}</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        onclick="return confirm('Are you sure you want to delete this post?')">{{ __('Delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ __('No posts found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        @if ($posts->count() > 0)
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                <form action="{{ route('admin.posts.bulk-action') }}" method="POST" id="bulk-action-form">
                    @csrf
                    <input type="hidden" name="action" id="bulk-action">
                    <input type="hidden" name="posts" id="bulk-posts">

                    <select id="bulk-action-select"
                        class="border-gray-300 dark:border-gray-600 dark:bg-gray-600 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 mr-2">
                        <option value="">{{ __('Bulk Actions') }}</option>
                        <option value="delete">{{ __('Delete') }}</option>
                    </select>

                    <button type="button" id="apply-bulk-action"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        {{ __('Apply') }}
                    </button>
                </form>
            </div>
        @endif

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            // Select all checkbox
            document.getElementById('select-all').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.post-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Bulk actions
            document.getElementById('apply-bulk-action').addEventListener('click', function() {
                const action = document.getElementById('bulk-action-select').value;
                const selectedPosts = Array.from(document.querySelectorAll('.post-checkbox:checked'))
                    .map(checkbox => checkbox.value);

                if (!action) {
                    alert('Please select an action.');
                    return;
                }

                if (selectedPosts.length === 0) {
                    alert('Please select at least one post.');
                    return;
                }

                if (action === 'delete' && !confirm('Are you sure you want to delete the selected posts?')) {
                    return;
                }

                document.getElementById('bulk-action').value = action;
                document.getElementById('bulk-posts').value = JSON.stringify(selectedPosts);
                document.getElementById('bulk-action-form').submit();
            });
        </script>
    @endpush
</x-layouts.admin>

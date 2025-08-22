<x-layouts.app>
    <x-slot name="title">{{ __('Home') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <!-- Create Post Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 mb-6">
            <div class="flex items-start space-x-3">
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                    class="w-10 h-10 rounded-full">
                <div class="flex-1">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="content" rows="3"
                            class="w-full border-0 focus:ring-0 resize-none bg-transparent text-gray-900 dark:text-white placeholder-gray-500"
                            placeholder="{{ __('What\'s happening?') }}"></textarea>

                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center space-x-4">
                                <label
                                    class="cursor-pointer text-gray-500 dark:text-gray-400 hover:text-blue-500 dark:hover:text-blue-400">
                                    <input type="file" name="image" accept="image/*" class="hidden"
                                        onchange="previewImage(this)">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_public" checked
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span
                                        class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Public') }}</span>
                                </label>
                            </div>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-full">
                                {{ __('Post') }}
                            </button>
                        </div>

                        <div id="image-preview" class="mt-3 hidden">
                            <img id="preview" class="w-full rounded-lg max-h-60 object-cover">
                            <button type="button" onclick="removeImage()" class="mt-2 text-red-600 hover:text-red-800">
                                {{ __('Remove image') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Posts -->
        <div id="posts-container">
            @include('posts.partials.posts', ['posts' => $posts])
        </div>

        @if ($posts->hasMorePages())
            <div class="text-center mt-6">
                <button id="load-more"
                    class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-blue-600 font-medium py-2 px-4 rounded-lg border border-gray-300 dark:border-gray-600">
                    {{ __('Load more') }}
                </button>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview').src = e.target.result;
                        document.getElementById('image-preview').classList.remove('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function removeImage() {
                document.querySelector('input[name="image"]').value = '';
                document.getElementById('image-preview').classList.add('hidden');
            }

            // Infinite scroll
            document.getElementById('load-more')?.addEventListener('click', function() {
                const nextPageUrl = '{{ $posts->nextPageUrl() }}';
                if (nextPageUrl) {
                    this.disabled = true;
                    this.textContent = 'Loading...';

                    fetch(nextPageUrl)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('posts-container').innerHTML += data.html;
                            if (data.next_page) {
                                this.dataset.nextPage = data.next_page;
                            } else {
                                this.remove();
                            }
                            this.disabled = false;
                            this.textContent = 'Load more';
                        });
                }
            });
        </script>
    @endpush
</x-layouts.app>

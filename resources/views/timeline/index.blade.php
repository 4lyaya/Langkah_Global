@extends('layouts.app')

@section('title', __('Timeline'))

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Create Post -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex space-x-4">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                        class="w-10 h-10 rounded-full">
                    <div class="flex-1">
                        <textarea name="content" rows="3" placeholder="{{ __('What\'s on your mind?') }}"
                            class="w-full border-0 focus:ring-0 resize-none bg-gray-50 dark:bg-gray-700 rounded-lg p-3 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="previewImage" class="w-full h-48 object-cover rounded-lg">
                            <button type="button" onclick="removeImage()" class="mt-2 text-red-600 text-sm">
                                {{ __('Remove image') }}
                            </button>
                        </div>

                        <div class="flex items-center justify-between mt-3">
                            <div class="flex items-center space-x-4">
                                <label for="image"
                                    class="cursor-pointer text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <input type="file" name="image" id="image" accept="image/*" class="hidden"
                                        onchange="previewFile()">
                                </label>

                                <label
                                    class="flex items-center space-x-2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                                    <input type="checkbox" name="is_public" value="1" checked
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    <span class="text-sm">{{ __('Public') }}</span>
                                </label>
                            </div>
                            <button type="submit"
                                class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                {{ __('Post') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Posts -->
        <div id="posts-container">
            @include('posts.partials.posts', ['posts' => $posts])
        </div>

        @if ($posts->hasMorePages())
            <div id="load-more-container" class="text-center mt-6">
                <button id="load-more"
                    class="bg-white dark:bg-gray-800 text-primary-600 px-6 py-3 rounded-lg shadow-md hover:bg-gray-50 dark:hover:bg-gray-700">
                    {{ __('Load more') }}
                </button>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        function previewFile() {
            const file = document.getElementById('image').files[0];
            const preview = document.getElementById('previewImage');
            const previewContainer = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }

        // Infinite scroll
        let page = 2;
        let isLoading = false;

        document.getElementById('load-more')?.addEventListener('click', loadMorePosts);

        function loadMorePosts() {
            if (isLoading) return;

            isLoading = true;
            const loadMoreBtn = document.getElementById('load-more');
            if (loadMoreBtn) loadMoreBtn.disabled = true;

            fetch(`?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        document.getElementById('posts-container').insertAdjacentHTML('beforeend', data.html);
                        page++;

                        if (!data.next_page) {
                            document.getElementById('load-more-container')?.remove();
                        }
                    } else {
                        document.getElementById('load-more-container')?.remove();
                    }
                })
                .catch(error => {
                    console.error('Error loading more posts:', error);
                })
                .finally(() => {
                    isLoading = false;
                    if (loadMoreBtn) loadMoreBtn.disabled = false;
                });
        }

        // Auto load on scroll
        window.addEventListener('scroll', () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
                loadMorePosts();
            }
        });
    </script>
@endpush

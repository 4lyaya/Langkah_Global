@extends('layouts.app')

@section('title', __('Edit Post'))

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6">{{ __('Edit Post') }}</h2>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Content') }}
                    </label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('content') border-red-500 @enderror"
                        placeholder="{{ __('What would you like to share?') }}">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($post->image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Current Image') }}
                        </label>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                            class="w-full h-48 object-cover rounded-lg">
                        <label class="flex items-center mt-2">
                            <input type="checkbox" name="remove_image" value="1"
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Remove image') }}</span>
                        </label>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('New Image (optional)') }}
                    </label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('image') border-red-500 @enderror">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <div id="imagePreview" class="mt-3 hidden">
                        <img id="previewImage" class="w-full h-48 object-cover rounded-lg">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" value="1" {{ $post->is_public ? 'checked' : '' }}
                            class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                        <span
                            class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Make this post public') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('posts.show', $post) }}"
                        class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        {{ __('Update Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('image').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('previewImage');
                const previewContainer = document.getElementById('imagePreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        </script>
    @endpush
@endsection

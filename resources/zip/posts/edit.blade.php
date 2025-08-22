<x-layouts.app>
    <x-slot name="title">{{ __('Edit Post') }}</x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">{{ __('Edit Post') }}</h1>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label for="content"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Content') }}</label>
                    <textarea name="content" id="content" rows="6"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($post->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                            class="w-full rounded-lg max-h-60 object-cover">
                        <label class="flex items-center mt-2">
                            <input type="checkbox" name="remove_image"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remove image') }}</span>
                        </label>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="image"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('New Image (Optional)') }}</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_public" {{ $post->is_public ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span
                            class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Make this post public') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('posts.show', $post) }}"
                        class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md">
                        {{ __('Update Post') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

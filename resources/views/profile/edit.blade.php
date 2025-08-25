@extends('layouts.app')

@section('title', __('Edit Profile'))

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-6 text-gray-900 dark:text-white">{{ __('Edit Profile') }}</h2>

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if ($errors->any())
                <div
                    class="bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Profile Photo -->
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="profilePhotoPreview"
                            class="h-24 w-24 object-cover rounded-full border-2 border-gray-300 dark:border-gray-600"
                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Profile Photo') }}
                        </label>
                        <input type="file" name="profile_photo" id="profile_photo" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400"
                            onchange="previewProfilePhoto(event)">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('JPG, PNG or GIF. Max size: 2MB') }}
                        </p>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Full Name') }} *
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Username') }} *
                        </label>
                        <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                            required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Email Address') }} *
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                            required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Phone Number') }}
                        </label>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="birthdate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Birthdate') }}
                        </label>
                        <input type="date" name="birthdate" id="birthdate"
                            value="{{ old('birthdate', $user->birthdate ? $user->birthdate->format('Y-m-d') : '') }}"
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('birthdate') border-red-500 @enderror">
                        @error('birthdate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Language') }} *
                        </label>
                        <select name="language" id="language" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('language') border-red-500 @enderror">
                            <option value="en" {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English
                            </option>
                            <option value="id" {{ old('language', $user->language) == 'id' ? 'selected' : '' }}>
                                Indonesia</option>
                            <option value="zh" {{ old('language', $user->language) == 'zh' ? 'selected' : '' }}>中文
                            </option>
                        </select>
                        @error('language')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Bio') }}
                    </label>
                    <textarea name="bio" id="bio" rows="3"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('bio') border-red-500 @enderror"
                        placeholder="{{ __('Tell us about yourself...') }}">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Maximum 500 characters') }}
                    </p>
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Website') }}
                    </label>
                    <input type="url" name="website" id="website" value="{{ old('website', $user->website) }}"
                        class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('website') border-red-500 @enderror"
                        placeholder="https://example.com">
                    @error('website')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Privacy Settings -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Privacy Settings') }}</h3>

                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="is_private" id="is_private" value="1"
                                {{ old('is_private', $user->is_private) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                            <label for="is_private" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Make my account private') }}
                            </label>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('When your account is private, only approved followers can see your posts and profile information.') }}
                        </p>

                        <div class="flex items-center">
                            <input type="checkbox" name="dark_mode" id="dark_mode" value="1"
                                {{ old('dark_mode', $user->dark_mode) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                            <label for="dark_mode" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Enable dark mode') }}
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('profile.show', $user) }}"
                        class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="bg-primary-600 text-white px-6 py-2 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200">
                        {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div x-data="{ open: false }"
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-red-200 dark:border-red-800">
            <h3 class="text-lg font-medium text-red-800 dark:text-red-400 mb-4">{{ __('Danger Zone') }}</h3>

            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Delete Account') }}</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Once you delete your account, there is no going back. Please be certain.') }}
                    </p>
                </div>
                <button @click="open = true"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors duration-200">
                    {{ __('Delete Account') }}
                </button>
            </div>

            <!-- Delete Account Modal -->
            <div x-show="open" x-cloak
                class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
                @click.self="open = false">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Delete Account') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        {{ __('Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently removed.') }}
                    </p>

                    <form action="{{ route('profile.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label for="confirm_password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Enter your password to confirm') }}
                            </label>
                            <input type="password" name="confirm_password" id="confirm_password" required
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="open = false"
                                class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500">
                                {{ __('Cancel') }}
                            </button>

                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                {{ __('Delete Account') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function previewProfilePhoto(event) {
            const input = event.target;
            const preview = document.getElementById('profilePhotoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        Initialize Alpine.js
        for modal
        document.addEventListener('alpine:init', () => {
            Alpine.data('deleteAccount', () => ({
                open: false,

                toggle() {
                    this.open = !this.open;
                }
            }));
        });
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

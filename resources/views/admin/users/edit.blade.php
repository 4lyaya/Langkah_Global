@extends('layouts.admin')

@section('admin-title', __('Edit User') . ' - ' . $user->name)

@section('admin-content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit User') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('User ID') }}: #{{ $user->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.show', $user) }}"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('Back to Profile') }}
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    {{ __('All Users') }}
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div
                class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('User Information') }}</h3>

                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Full Name') }} *
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    required
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="username"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Username') }} *
                                </label>
                                <input type="text" name="username" id="username"
                                    value="{{ old('username', $user->username) }}" required
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('username') border-red-500 @enderror">
                                @error('username')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Email Address') }} *
                                </label>
                                <input type="email" name="email" id="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Phone Number') }}
                                </label>
                                <input type="tel" name="phone" id="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-6">
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

                        <div class="mb-6">
                            <label for="website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('Website') }}
                            </label>
                            <input type="url" name="website" id="website"
                                value="{{ old('website', $user->website) }}"
                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('website') border-red-500 @enderror"
                                placeholder="https://example.com">
                            @error('website')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preferences -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="language"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Language') }} *
                                </label>
                                <select name="language" id="language" required
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('language') border-red-500 @enderror">
                                    <option value="en"
                                        {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="id"
                                        {{ old('language', $user->language) == 'id' ? 'selected' : '' }}>Indonesia</option>
                                    <option value="zh"
                                        {{ old('language', $user->language) == 'zh' ? 'selected' : '' }}>中文</option>
                                </select>
                                @error('language')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Privacy Settings -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                            <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">{{ __('Privacy Settings') }}
                            </h4>

                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_private" id="is_private" value="1"
                                        {{ old('is_private', $user->is_private) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                                    <label for="is_private" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                        {{ __('Make account private') }}
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 ml-6">
                                    {{ __('When account is private, only approved followers can see posts and profile information.') }}
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
                            <a href="{{ route('admin.users.show', $user) }}"
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
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('User Summary') }}</h3>

                    <div class="text-center mb-4">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="w-20 h-20 rounded-full mx-auto mb-3">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">@{{ $user - > username }}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">ID: #{{ $user->id }}</p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Member since') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->created_at->format('M j, Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Last updated') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Posts') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->posts_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Followers') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->followers_count }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Following') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->following_count }}</span>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Account Status') }}</h3>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Email Verified') }}:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                {{ $user->email_verified_at ? __('Yes') : __('No') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Account Status') }}:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                {{ __('Active') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Admin Role') }}:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->isAdmin() ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' }}">
                                {{ $user->isAdmin() ? __('Administrator') : __('Regular User') }}
                            </span>
                        </div>
                    </div>

                    @if ($user->isAdmin())
                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <a href="{{ route('admin.admins.index') }}"
                                class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors duration-200 text-center block text-sm">
                                {{ __('Manage Admin Settings') }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Danger Zone -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 border border-red-200 dark:border-red-800">
                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-400 mb-4">{{ __('Danger Zone') }}</h3>

                    @if (!$user->isAdmin())
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                {{ __('Once you delete this account, there is no going back. Please be certain.') }}
                            </p>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200 text-sm"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}')">
                                    {{ __('Delete User Account') }}
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mb-4">
                            <p class="text-sm text-yellow-600 dark:text-yellow-400 mb-3">
                                {{ __('Admin accounts cannot be deleted from here. Please remove admin privileges first.') }}
                            </p>
                            <button disabled
                                class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed text-sm">
                                {{ __('Delete Disabled for Admins') }}
                            </button>
                        </div>
                    @endif

                    @if (auth()->user()->isSuperAdmin() && !$user->is(auth()->user()))
                        <div class="pt-4 border-t border-red-200 dark:border-red-700">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                {{ __('Impersonate this user to experience the platform from their perspective.') }}
                            </p>
                            <form action="{{ route('admin.users.impersonate', $user) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm"
                                    onclick="return confirm('{{ __('Are you sure you want to impersonate this user?') }}')">
                                    {{ __('Impersonate User') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Real-time validation or additional functionality can be added here
        document.addEventListener('DOMContentLoaded', function() {
            // Username availability check (optional enhancement)
            const usernameInput = document.getElementById('username');
            const usernameFeedback = document.createElement('div');
            usernameFeedback.className = 'mt-1 text-sm';
            usernameInput.parentNode.appendChild(usernameFeedback);

            usernameInput.addEventListener('blur', function() {
                const username = this.value;
                if (username.length < 3) {
                    return;
                }

                // Check username availability via AJAX
                fetch(`/api/check-username?username=${username}&user_id={{ $user->id }}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.available) {
                            usernameFeedback.className = 'mt-1 text-sm text-green-600';
                            usernameFeedback.textContent = '{{ __('Username is available') }}';
                        } else {
                            usernameFeedback.className = 'mt-1 text-sm text-red-600';
                            usernameFeedback.textContent = '{{ __('Username is already taken') }}';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Email format validation
            const emailInput = document.getElementById('email');
            emailInput.addEventListener('blur', function() {
                const email = this.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (!emailRegex.test(email)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });
        });
    </script>
@endpush

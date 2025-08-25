@extends('layouts.admin')

@section('admin-title', __('User Profile') . ' - ' . $user->name)

@section('admin-content')
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('User Profile') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('User ID') }}: #{{ $user->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                    {{ __('Edit Profile') }}
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

        <!-- Success Message -->
        @if (session('success'))
            <div
                class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Header -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-6">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                            class="w-24 h-24 rounded-full border-4 border-white dark:border-gray-600">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                                    <p class="text-gray-600 dark:text-gray-400">@{{ $user - > username }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($user->isAdmin())
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                                    clip-rule="evenodd"></path>
                                                <path fill-rule="evenodd" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            {{ __('Administrator') }}
                                        </span>
                                    @endif
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->is_private ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                        {{ $user->is_private ? __('Private Account') : __('Public Account') }}
                                    </span>
                                </div>
                            </div>

                            @if ($user->bio)
                                <p class="mt-3 text-gray-700 dark:text-gray-300">{{ $user->bio }}</p>
                            @endif

                            <div class="flex items-center space-x-6 mt-4 text-sm">
                                <span class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    {{ $user->posts_count }} {{ __('Posts') }}
                                </span>
                                <span class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    {{ $user->followers_count }} {{ __('Followers') }}
                                </span>
                                <span class="flex items-center text-gray-600 dark:text-gray-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    {{ $user->following_count }} {{ __('Following') }}
                                </span>
                            </div>

                            @if ($user->website)
                                <div class="mt-3">
                                    <a href="{{ $user->website }}" target="_blank"
                                        class="text-primary-600 hover:text-primary-500 text-sm flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>
                                        {{ parse_url($user->website, PHP_URL_HOST) }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('User Statistics') }}</h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $user->posts_count }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Posts') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalLikes }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Likes') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalComments }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Comments') }}</div>
                        </div>
                        <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                {{ number_format($avgEngagement, 1) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Avg Engagement') }}</div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('Account Created') }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->created_at->format('F j, Y') }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('Last Updated') }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->updated_at->format('F j, Y') }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">{{ $user->updated_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Recent Posts') }}</h3>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $user->posts_count }}
                            {{ __('total posts') }}</span>
                    </div>

                    @if ($posts->count() > 0)
                        <div class="space-y-4">
                            @foreach ($posts as $post)
                                <div
                                    class="border border-gray-200 dark:border-gray-600 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-gray-800 dark:text-gray-200 text-sm mb-2 line-clamp-2">
                                                {{ $post->content }}
                                            </p>
                                            <div
                                                class="flex items-center space-x-4 text-xs text-gray-500 dark:text-gray-400">
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ $post->likes_count }}
                                                </span>
                                                <span class="flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                                        </path>
                                                    </svg>
                                                    {{ $post->comments_count }}
                                                </span>
                                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        @if ($post->image)
                                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post image"
                                                class="w-16 h-16 rounded-lg object-cover ml-4">
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($posts->hasPages())
                            <div class="mt-6">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8 text-gray-400 dark:text-gray-500">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p>{{ __('No posts yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Account Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Account Information') }}
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Email') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Phone') }}:</span>
                            <span class="text-gray-900 dark:text-white">{{ $user->phone ?: __('Not provided') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Language') }}:</span>
                            <span class="text-gray-900 dark:text-white">
                                @switch($user->language)
                                    @case('id')
                                        Indonesia
                                    @break

                                    @case('zh')
                                        中文
                                    @break

                                    @default
                                        English
                                @endswitch
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Theme') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $user->dark_mode ? __('Dark Mode') : __('Light Mode') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Email Verified') }}:</span>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                {{ $user->email_verified_at ? __('Yes') : __('No') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Quick Actions') }}</h3>

                    <div class="space-y-2">
                        <a href="{{ route('profile.show', $user) }}" target="_blank"
                            class="w-full flex items-center justify-between px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                            <span>{{ __('View Public Profile') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>

                        @if (auth()->user()->isSuperAdmin() && !$user->is(auth()->user()))
                            <form action="{{ route('admin.users.impersonate', $user) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center justify-between px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800/30 transition-colors duration-200"
                                    onclick="return confirm('{{ __('Are you sure you want to impersonate this user?') }}')">
                                    <span>{{ __('Impersonate User') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        @if (!$user->isAdmin())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-between px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-800/30 transition-colors duration-200"
                                    onclick="return confirm('{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}')">
                                    <span>{{ __('Delete User') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <div
                                class="w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400 rounded-lg text-sm">
                                {{ __('Admin users cannot be deleted') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- System Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('System Information') }}
                    </h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('User ID') }}:</span>
                            <span class="text-gray-900 dark:text-white">#{{ $user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Account Type') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $user->isAdmin() ? __('Administrator') : __('Regular User') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Registration IP') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $user->registration_ip ?: __('Not available') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">{{ __('Last Login') }}:</span>
                            <span
                                class="text-gray-900 dark:text-white">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : __('Never') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </style>
@endpush

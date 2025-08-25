@extends('layouts.admin')

@section('admin-title', __('Users Management'))

@section('admin-content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Users Management') }}</h3>

                <!-- Search Form -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center space-x-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search users...') }}"
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
                        <a href="{{ route('admin.users.index') }}"
                            class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                            {{ __('Clear') }}
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $totalUsers }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Users') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activeUsers }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Active Users') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $adminCount }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Admins') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $privateAccounts }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Private Accounts') }}</div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('User') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Contact') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Stats') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Joined') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <!-- User Information -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                        class="w-10 h-10 rounded-full">
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $user->name }}
                                            @if ($user->isAdmin())
                                                <span class="ml-1 text-primary-600 dark:text-primary-400"
                                                    title="{{ __('Administrator') }}">
                                                    <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                                            clip-rule="evenodd"></path>
                                                        <path fill-rule="evenodd" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $user->username }}
                                        </div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                            ID: #{{ $user->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Information -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $user->phone ?: __('No phone') }}
                                </div>
                            </td>

                            <!-- Stats -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2 text-xs">
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        {{ $user->posts_count }} {{ __('posts') }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                            </path>
                                        </svg>
                                        {{ $user->followers_count }} {{ __('followers') }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                            </path>
                                        </svg>
                                        {{ $user->following_count }} {{ __('following') }}
                                    </span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-1">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_private ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' }}">
                                        {{ $user->is_private ? __('Private') : __('Public') }}
                                    </span>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->dark_mode ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                        {{ $user->dark_mode ? __('Dark Mode') : __('Light Mode') }}
                                    </span>
                                    @if ($user->email_verified_at)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                            {{ __('Verified') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            </svg>
                                            {{ __('Unverified') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Joined Date -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $user->created_at->format('M j, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                        class="text-primary-600 hover:text-primary-900 dark:hover:text-primary-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                        title="{{ __('View Profile') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                        title="{{ __('Edit User') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    @if (!$user->isAdmin())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                                onclick="return confirm('{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}')"
                                                title="{{ __('Delete User') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed p-1"
                                            title="{{ __('Cannot delete admin users') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </span>
                                    @endif

                                    @if (auth()->user()->isSuperAdmin() && !$user->is(auth()->user()))
                                        <form action="{{ route('admin.users.impersonate', $user) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-purple-600 hover:text-purple-900 dark:hover:text-purple-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                                title="{{ __('Impersonate User') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">{{ __('No users found') }}</p>
                                    <p class="text-sm">{{ __('Try adjusting your search criteria.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $users->links() }}
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality with debounce
            const searchInput = document.querySelector('input[name="search"]');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.form.submit();
                }, 500);
            });

            // Confirm before impersonating
            const impersonateForms = document.querySelectorAll('form[action*="impersonate"]');
            impersonateForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('{{ __('Are you sure you want to impersonate this user?') }}')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endpush

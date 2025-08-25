@extends('layouts.admin')

@section('admin-title', __('Admins Management'))

@section('admin-content')
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div x-data="{ open: false }">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('Admins Management') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Manage administrator accounts and permissions') }}</p>
                </div>

                @if (auth()->user()->isSuperAdmin())
                    <div>
                        <button @click="open = true"
                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            {{ __('Add Admin') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="px-6 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $admins->total() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Total Admins') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $superAdminsCount }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Super Admins') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $regularAdminsCount }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Regular Admins') }}</div>
                </div>
                <div class="text-center p-3 bg-white dark:bg-gray-600 rounded-lg">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $activeAdminsCount }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Active Admins') }}</div>
                </div>
            </div>
        </div>

        <!-- Admins Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Admin') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Role') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Permissions') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Status') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Added') }}
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <!-- Admin Information -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $admin->user->profile_photo_url }}" alt="{{ $admin->user->name }}"
                                        class="w-10 h-10 rounded-full">
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $admin->user->name }}
                                            @if ($admin->user->is(auth()->user()))
                                                <span
                                                    class="ml-2 text-xs text-primary-600 dark:text-primary-400">({{ __('You') }})</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                            {{ $admin->user->username }}
                                        </div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500">
                                            {{ $admin->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $admin->role === 'super_admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' }}">
                                    @if ($admin->role === 'super_admin')
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                                clip-rule="evenodd"></path>
                                            <path fill-rule="evenodd" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ __('Super Admin') }}
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd">
                                            </path>
                                        </svg>
                                        {{ __('Admin') }}
                                    @endif
                                </span>
                            </td>

                            <!-- Permissions -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1 text-xs">
                                    @if ($admin->role === 'super_admin')
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                            {{ __('Full Access') }}
                                        </span>
                                    @else
                                        @foreach ($admin->permissions ?? [] as $permission)
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                {{ __(ucfirst(str_replace('_', ' ', $permission))) }}
                                            </span>
                                        @endforeach
                                        @if (empty($admin->permissions))
                                            <span
                                                class="text-gray-400 dark:text-gray-500">{{ __('No permissions') }}</span>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ __('Active') }}
                                </span>
                            </td>

                            <!-- Added Date -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $admin->created_at->format('M j, Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $admin->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    @if (auth()->user()->isSuperAdmin())
                                        <button
                                            @click="openEditModal({{ $admin->id }}, '{{ $admin->role }}', {{ json_encode($admin->permissions ?? []) }})"
                                            class="text-blue-600 hover:text-blue-900 dark:hover:text-blue-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                            title="{{ __('Edit Admin') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if (!$admin->user->is(auth()->user()) && $admin->role !== 'super_admin')
                                            <form action="{{ route('admin.admins.delete', $admin) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 dark:hover:text-red-400 p-1 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                                    onclick="return confirm('{{ __('Are you sure you want to remove admin privileges?') }}')"
                                                    title="{{ __('Remove Admin') }}">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 cursor-not-allowed p-1"
                                                title="{{ __('Cannot remove your own admin access or super admin') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                    </path>
                                                </svg>
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed p-1"
                                            title="{{ __('Only super admins can manage admins') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                </path>
                                            </svg>
                                        </span>
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
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <p class="text-lg font-medium mb-2">{{ __('No administrators found') }}</p>
                                    <p class="text-sm">{{ __('Add new administrators to manage the platform.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($admins->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
                {{ $admins->links() }}
            </div>
        @endif
    </div>

    <!-- Add Admin Modal -->
    @if (auth()->user()->isSuperAdmin())
        <div x-data="{ open: false, errors: {} }" x-show="open" x-cloak
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Add New Administrator') }}</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.admins.create') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Select User') }} *
                        </label>
                        <select name="user_id" id="user_id" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">{{ __('Choose a user') }}</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->username }}) - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        <template x-if="errors.user_id">
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.user_id[0]"></p>
                        </template>
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Role') }} *
                        </label>
                        <select name="role" id="role" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}
                            </option>
                            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>
                                {{ __('Super Admin') }}</option>
                        </select>
                        <template x-if="errors.role">
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.role[0]"></p>
                        </template>
                    </div>

                    <div class="mb-4" id="permissions-section">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Permissions') }}
                        </label>
                        <div class="space-y-2">
                            @foreach (['manage_users', 'manage_posts', 'manage_comments', 'manage_settings'] as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                        {{ in_array($permission, old('permissions', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __(ucfirst(str_replace('_', ' ', $permission))) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <template x-if="errors.permissions">
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.permissions[0]"></p>
                        </template>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="open = false; errors = {};"
                            class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            {{ __('Add Administrator') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Edit Admin Modal -->
    @if (auth()->user()->isSuperAdmin())
        <div x-data="{
            open: false,
            editingAdmin: null,
            currentRole: 'admin',
            currentPermissions: [],
            errors: {}
        }" x-show="open" x-cloak
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('Edit Administrator') }}</h3>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form :action="'{{ url('admin/admins') }}/' + editingAdmin" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="edit_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Role') }} *
                        </label>
                        <select name="role" id="edit_role" x-model="currentRole" required
                            class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="admin">{{ __('Admin') }}</option>
                            <option value="super_admin">{{ __('Super Admin') }}</option>
                        </select>
                        <template x-if="errors.role">
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.role[0]"></p>
                        </template>
                    </div>

                    <div class="mb-4" id="edit_permissions-section" x-show="currentRole !== 'super_admin'">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('Permissions') }}
                        </label>
                        <div class="space-y-2">
                            @foreach (['manage_users', 'manage_posts', 'manage_comments', 'manage_settings'] as $permission)
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission }}"
                                        :checked="currentPermissions.includes('{{ $permission }}')"
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500 dark:bg-gray-700">
                                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        {{ __(ucfirst(str_replace('_', ' ', $permission))) }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <template x-if="errors.permissions">
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400" x-text="errors.permissions[0]"></p>
                        </template>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="open = false; errors = {};"
                            class="bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                            {{ __('Update Administrator') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
        function openEditModal(adminId, role, permissions) {
            // Set the admin data for editing
            Alpine.store('editModal').editingAdmin = adminId;
            Alpine.store('editModal').currentRole = role;
            Alpine.store('editModal').currentPermissions = permissions || [];
            Alpine.store('editModal').open = true;
        }

        // Initialize Alpine store for the edit modal
        document.addEventListener('alpine:init', () => {
            Alpine.store('editModal', {
                open: false,
                editingAdmin: null,
                currentRole: 'admin',
                currentPermissions: [],
                errors: {}
            });
        });

        // Toggle permissions section based on role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const permissionsSection = document.getElementById('permissions-section');

            if (roleSelect && permissionsSection) {
                roleSelect.addEventListener('change', function() {
                    if (this.value === 'super_admin') {
                        permissionsSection.style.display = 'none';
                    } else {
                        permissionsSection.style.display = 'block';
                    }
                });

                // Trigger change event on load
                roleSelect.dispatchEvent(new Event('change'));
            }
        });

        // Handle form validation errors for modals
        @if ($errors->any())
            @if (session('form_type') === 'create')
                document.addEventListener('DOMContentLoaded', function() {
                    // Show create modal with errors
                    Alpine.store('createModal').open = true;
                    Alpine.store('createModal').errors = @json($errors->toArray());
                });
            @elseif (session('form_type') === 'edit')
                document.addEventListener('DOMContentLoaded', function() {
                    // Show edit modal with errors
                    Alpine.store('editModal').open = true;
                    Alpine.store('editModal').editingAdmin = {{ session('editing_admin_id', 'null') }};
                    Alpine.store('editModal').currentRole = '{{ old('role', 'admin') }}';
                    Alpine.store('editModal').currentPermissions = @json(old('permissions', []));
                    Alpine.store('editModal').errors = @json($errors->toArray());
                });
            @endif
        @endif
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
@endpush

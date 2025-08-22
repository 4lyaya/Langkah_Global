<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Membuat user super admin
        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'phone' => '081234567890',
            'password' => Hash::make('password123'), // ganti dengan password aman
            'birthdate' => '1990-01-01',
            'profile_photo' => null,
            'bio' => 'This is the super admin account.',
            'website' => null,
            'language' => 'en',
            'is_private' => false,
            'dark_mode' => false,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Membuat entry admin terkait user
        Admin::create([
            'user_id' => $user->id,
            'role' => 'super_admin',
            'permissions' => json_encode([
                'manage_users' => true,
                'manage_posts' => true,
                'manage_settings' => true,
            ]),
        ]);
    }
}

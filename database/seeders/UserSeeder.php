<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
            'nik' => '1234567890123456',
            'address' => 'Jl. Admin No. 1',
            'phone' => '081234567890',
            'ktp' => 'ktp/admin.jpg',
            'kk' => 'kk/admin.jpg',
        ]);

        // Create Sample User
        User::create([
            'name' => 'User Test',
            'email' => 'user@user.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
            'nik' => '6543210987654321',
            'address' => 'Jl. User No. 1',
            'phone' => '089876543210',
            'ktp' => 'ktp/user.jpg',
            'kk' => 'kk/user.jpg',
        ]);

        // Create 5 more random users
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@user.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
                'nik' => str_pad($i, 16, '0', STR_PAD_LEFT),
                'address' => 'Jl. User No. ' . $i,
                'phone' => '08' . str_pad($i, 10, '0', STR_PAD_LEFT),
                'ktp' => 'ktp/user' . $i . '.jpg',
                'kk' => 'kk/user' . $i . '.jpg',
            ]);
        }
    }
} 
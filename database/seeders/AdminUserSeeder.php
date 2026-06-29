<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@glowbeauty.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@glowbeauty.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '1234567890'
            ]
        );
    }
}
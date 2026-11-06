<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '08123456789',
            ]
        );

        // PIC
        User::updateOrCreate(
            ['email' => 'pic@gmail.com'],
            [
                'name' => 'PIC RPL',
                'password' => Hash::make('pic123'),
                'role' => 'pic',
                'phone' => '08123456780',
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user - PERBAIKI EMAILNYA
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tokobukuchel.com', // Hapus underscore setelah @
            'password' => Hash::make('chelsea.0910'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample user
        User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@tokobukuchel.com'); // Update info juga
        $this->command->info('Password: chelsea.0910');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // use a secure password
            'role' => 'admin', // assuming you have a 'role' column
        ]);

        // Create Technician user
        User::create([
            'name' => 'Technician User',
            'email' => 'technician@example.com',
            'password' => Hash::make('password123'),
            'role' => 'technician',
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    // Create additional random students
    User::factory(10)->create(['role' => 'student']);

    // Create additional random technicians
    User::factory(5)->create(['role' => 'technician']);
    }
}

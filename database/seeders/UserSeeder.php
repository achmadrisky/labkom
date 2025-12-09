<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Dosen
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
            'role' => 'lecturer',
        ]);

        // Mahasiswa
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}

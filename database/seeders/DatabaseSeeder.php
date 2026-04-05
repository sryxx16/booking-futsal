<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun Admin Default
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@futsal.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // (Opsional) Bikin 1 akun user biasa buat testing
        User::create([
            'name' => 'User Testing',
            'email' => 'user@futsal.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);
    }
}

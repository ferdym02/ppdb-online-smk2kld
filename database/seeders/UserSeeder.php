<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password'), // Pastikan menggunakan hashing untuk keamanan
                'role' => 'admin', // Set role sebagai 'admin'
            ],
            [
                'name' => 'Ferdy',
                'email' => 'ferdywan02@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user', // Default role
            ],
            [
                'name' => 'Superadmin',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
                'role' => 'superadmin', // Set role sebagai 'superadmin'
            ],
        ]);
    }
}

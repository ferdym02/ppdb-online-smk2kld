<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmins = [
            [
                'name' => 'Admin 3',
                'email' => 'admin3@example.com',
            ],
            [
                'name' => 'Admin 4',
                'email' => 'admin4@example.com',
            ],
            [
                'name' => 'Admin 5',
                'email' => 'admin5@example.com',
            ],
            [
                'name' => 'Admin 6',
                'email' => 'admin6@example.com',
            ],
            [
                'name' => 'Admin 7',
                'email' => 'admin7@example.com',
            ],
        ];

        foreach ($superadmins as $admin) {
            // Hanya buat jika belum ada user dengan email tersebut
            if (!User::where('email', $admin['email'])->exists()) {
                User::create([
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => Hash::make('password'), // Ganti dengan password aman
                    'role' => 'superadmin',
                ]);
            }
        }
    }
}

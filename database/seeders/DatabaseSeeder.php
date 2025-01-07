<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    public function run(): void
    {
        // \App\Models\Pendaftar::factory(72)->create();
        $this->call(UserSeeder::class);
        $this->call(SchoolProfileSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(JadwalsSeeder::class);
    }
}

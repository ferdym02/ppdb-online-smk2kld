<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurusans')->insert([
            ['kode' => 'APL', 'nama' => 'Agribisnis Perikanan Payau dan Laut'],
            ['kode' => 'APT', 'nama' => 'Agribisnis Perikanan Tawar'],
            ['kode' => 'DPIB', 'nama' => 'Desain Pemodelan dan Informasi Bangunan'],
            ['kode' => 'TAV', 'nama' => 'Teknik Audio Video'],
            ['kode' => 'TITL', 'nama' => 'Teknik Instalasi Tenaga Listrik'],
            ['kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan'],
            ['kode' => 'TKP', 'nama' => 'Teknik Konstruksi dan Perumahan'],
            ['kode' => 'TKR', 'nama' => 'Teknik Kendaraan Ringan'],
            ['kode' => 'TP', 'nama' => 'Teknik Pemesinan'],
            ['kode' => 'TSM', 'nama' => 'Teknik Sepeda Motor'],
        ]);
    }
}

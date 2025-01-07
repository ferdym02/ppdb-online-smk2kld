<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('school_profiles')->insert([
            'nama_sekolah' => 'SMK Negeri 2 Kalianda',
            'alamat_sekolah' => 'Jl. Soekarno-Hatta Km No.52, Kedaton, Kec. Kalianda, Kabupaten Lampung Selatan, Lampung 35551',
            'email_sekolah' => 'smkn02kalianda@gmail.com',
            'telepon_sekolah' => '(0727) 322282',
            'logo_sekolah' => 'logos/school-logo.png',
            'facebook' => 'https://www.facebook.com/smk2kld/',
            'instagram' => 'https://www.instagram.com/smk2kld/',
            'call_center_1' => '081234567890',
            'call_center_2'=> '081234567891',
            'x' => 'https://twitter.com/smkn2kalianda',
            'tiktok' => 'https://www.tiktok.com/@smknegeri2kalianda',
        ]);
    }
}

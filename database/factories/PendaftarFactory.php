<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Pendaftar;
use App\Models\Jurusan;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pendaftar>
 */
class PendaftarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Pendaftar::class;

    public function definition(): array
    {
        return [
            'user_id' => function() {
                return \App\Models\User::factory()->create()->id;
            },
            'nomor_pendaftaran' => 'PDD' . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'nama_lengkap' => $this->faker->name,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date(),
            'asal_sekolah' => $this->faker->company,
            'nisn' => $this->faker->numerify('##########'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'nama_ayah' => $this->faker->name('male'),
            'nama_ibu' => $this->faker->name('female'),
            'nomor_wa' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'prestasi_akademik' => $this->faker->boolean,
            'prestasi_non_akademik' => $this->faker->boolean,
            'status_pendaftaran' => 'diterima',
            'tanggal_tes' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'status_tes' => 'sudah',
            'nilai_tes_minat_bakat' => 'A',
            'nilai_mtk_semester_1' => $this->faker->numberBetween(70, 100),
            'nilai_ipa_semester_1' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_indonesia_semester_1' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_inggris_semester_1' => $this->faker->numberBetween(70, 100),
            'nilai_mtk_semester_2' => $this->faker->numberBetween(70, 100),
            'nilai_ipa_semester_2' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_indonesia_semester_2' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_inggris_semester_2' => $this->faker->numberBetween(70, 100),
            'nilai_mtk_semester_3' => $this->faker->numberBetween(70, 100),
            'nilai_ipa_semester_3' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_indonesia_semester_3' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_inggris_semester_3' => $this->faker->numberBetween(70, 100),
            'nilai_mtk_semester_4' => $this->faker->numberBetween(70, 100),
            'nilai_ipa_semester_4' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_indonesia_semester_4' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_inggris_semester_4' => $this->faker->numberBetween(70, 100),
            'nilai_mtk_semester_5' => $this->faker->numberBetween(70, 100),
            'nilai_ipa_semester_5' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_indonesia_semester_5' => $this->faker->numberBetween(70, 100),
            'nilai_bahasa_inggris_semester_5' => $this->faker->numberBetween(70, 100),
            'periode_id' => 4,
            'nilai_akhir' => $this->faker->numberBetween(70, 100), // Nilai akhir acak
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pendaftar $pendaftar) {
            // Mendapatkan 3 jurusan secara acak
            $jurusan_ids = Jurusan::inRandomOrder()->take(3)->pluck('id');
            
            // Menyimpan jurusan pilihan
            foreach ($jurusan_ids as $index => $jurusan_id) {
                $pendaftar->jurusans()->attach($jurusan_id, ['urutan_pilihan' => $index + 1]);
            }

            // Memilih jurusan_diterima secara acak dari 3 pilihan
            // $jurusan_diterima = $jurusan_ids->random();
            // Memilih jurusan_diterima secara acak dari jurusan dengan id 1 atau 2
            $jurusan_diterima = Jurusan::whereIn('id', [1, 2])->inRandomOrder()->value('id');
            $pendaftar->jurusan_diterima = $jurusan_diterima;
            $pendaftar->save();
        });
    }

    private function storeFakeFile($fileField)
    {
        $fileName = $this->faker->word . '.pdf'; // Menghasilkan nama file dummy
        $filePath = storage_path('app/public/file_pendaftaran/' . $fileName);
        
        // Buat file dummy
        Storage::put('public/file_pendaftaran/' . $fileName, 'Dummy content for ' . $fileField);

        return 'file_pendaftaran/' . $fileName;
    }
}

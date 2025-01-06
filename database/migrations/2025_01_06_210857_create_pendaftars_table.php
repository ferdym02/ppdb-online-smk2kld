<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('asal_sekolah');
            $table->string('nisn');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('nomor_wa');
            $table->boolean('prestasi_akademik');
            $table->boolean('prestasi_non_akademik');
            $table->unsignedBigInteger('user_id');
            $table->string('kartu_keluarga')->nullable();
            $table->string('ktp_orang_tua')->nullable();
            $table->string('akte_kelahiran')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('foto_calon_siswa')->nullable();
            $table->string('raport')->nullable();
            $table->string('piagam')->nullable();
            $table->string('surat_keterangan')->nullable();
            $table->date('tanggal_tes')->nullable();
            $table->text('catatan_penolakan')->nullable();
            for ($i = 1; $i <= 5; $i++) {
                $table->decimal("nilai_mtk_semester_$i", 5, 2)->nullable();
                $table->decimal("nilai_ipa_semester_$i", 5, 2)->nullable();
                $table->decimal("nilai_bahasa_indonesia_semester_$i", 5, 2)->nullable();
                $table->decimal("nilai_bahasa_inggris_semester_$i", 5, 2)->nullable();
            }
            $table->unsignedBigInteger('periode_id');
            $table->enum('nilai_tes_minat_bakat', ['A', 'B', 'C', 'K'])->nullable();
            $table->enum('status_tes', ['belum', 'sudah'])->default('belum');
            $table->string('status_pendaftaran')->default('pending');
            $table->enum('daftar_ulang', ['ya', 'tidak'])->nullable();
            $table->unsignedBigInteger('jurusan_diterima')->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};

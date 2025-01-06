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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id(); // Primary key (UNSIGNED BIGINT)
            $table->string('kegiatan', 255); // Nama kegiatan
            $table->string('lokasi', 255); // Lokasi kegiatan
            $table->date('tanggal_mulai'); // Tanggal mulai
            $table->date('tanggal_selesai')->nullable(); // Tanggal selesai (opsional)
            $table->string('waktu', 255); // Waktu kegiatan
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};

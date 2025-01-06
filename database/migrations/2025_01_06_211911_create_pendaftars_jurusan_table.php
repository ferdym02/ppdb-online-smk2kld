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
        Schema::create('pendaftar_jurusan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->unsignedBigInteger('jurusan_id');
            $table->tinyInteger('urutan_pilihan');
            $table->timestamps();

            // Indexes
            $table->index('pendaftar_id', 'pendaftar_jurusan_pendaftar_id_foreign');
            $table->index('jurusan_id', 'pendaftar_jurusan_jurusan_id_foreign');

            // Foreign keys
            $table->foreign('pendaftar_id')
                  ->references('id')
                  ->on('pendaftars')
                  ->onDelete('cascade');

            $table->foreign('jurusan_id')
                  ->references('id')
                  ->on('jurusans')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars_jurusan');
    }
};

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
        Schema::create('periodes', function (Blueprint $table) {
            $table->id(); // Primary key with UNSIGNED BIGINT
            $table->string('tahun_pelajaran')->collation('utf8mb4_unicode_ci');
            $table->integer('kuota_penerimaan')->nullable();
            $table->unsignedInteger('kuota_penerimaan_used')->default(0);
            $table->date('tanggal_buka');
            $table->date('tanggal_tutup');
            $table->boolean('status')->default(false); // 0 or 1
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodes');
    }
};

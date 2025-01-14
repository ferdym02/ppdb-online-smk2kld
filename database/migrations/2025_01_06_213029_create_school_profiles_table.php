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
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id(); // Primary key (UNSIGNED BIGINT)
            $table->string('nama_sekolah', 255); // Nama sekolah
            $table->unsignedBigInteger('npsn');
            $table->text('alamat_sekolah'); // Alamat sekolah
            $table->string('email_sekolah', 255); // Email sekolah
            $table->string('telepon_sekolah', 255); // Telepon sekolah
            $table->string('logo_sekolah', 255); // Logo sekolah (opsional)
            $table->string('facebook', 255)->nullable(); // URL Facebook sekolah
            $table->string('instagram', 255)->nullable(); // URL Instagram sekolah
            $table->timestamps(); // created_at dan updated_at
            $table->string('call_center_1')->nullable();
            $table->string('call_center_2')->nullable();
            $table->string('x', 255)->nullable(); // URL Twitter atau lainnya
            $table->string('tiktok', 255)->nullable(); // URL TikTok sekolah
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};

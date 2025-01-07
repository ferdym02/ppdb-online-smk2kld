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
        Schema::create('periode_jurusan', function (Blueprint $table) {
            $table->id(); // Primary key with UNSIGNED BIGINT
            $table->unsignedBigInteger('jurusan_id');
            $table->unsignedBigInteger('periode_id');
            $table->integer('kuota')->default(0); // Kuota for each combination
            $table->timestamps(); // created_at and updated_at

            // Foreign key constraints
            $table->foreign('jurusan_id')->references('id')->on('jurusans')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_jurusan');
    }
};

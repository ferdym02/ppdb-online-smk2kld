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
        Schema::table('pendaftars', function (Blueprint $table) {
            for ($i = 1; $i <= 5; $i++) {
                $table->decimal("nilai_mtk_semester_$i", 6, 2)->change();
                $table->decimal("nilai_ipa_semester_$i", 6, 2)->change();
                $table->decimal("nilai_bahasa_indonesia_semester_$i", 6, 2)->change();
                $table->decimal("nilai_bahasa_inggris_semester_$i", 6, 2)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftars', function (Blueprint $table) {
            for ($i = 1; $i <= 5; $i++) {
                $table->decimal("nilai_mtk_semester_$i", 5, 2)->change();
                $table->decimal("nilai_ipa_semester_$i", 5, 2)->change();
                $table->decimal("nilai_bahasa_indonesia_semester_$i", 5, 2)->change();
                $table->decimal("nilai_bahasa_inggris_semester_$i", 5, 2)->change();
            }
        });
    }
};

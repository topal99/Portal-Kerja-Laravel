<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            // Tambahkan kolom setelah kolom 'salary_range'
            $table->enum('education_level', ['SMA/SMK', 'D3', 'S1', 'S2', 'S3'])->nullable()->after('salary_range');
            $table->tinyInteger('experience_years')->unsigned()->nullable()->after('education_level');
        });
    }

    public function down(): void
    {
        Schema::table('job_listings', function (Blueprint $table) {
            // Hapus kolom jika migrasi di-rollback
            $table->dropColumn(['education_level', 'experience_years']);
        });
    }
};
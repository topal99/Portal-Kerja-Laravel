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
        // Hapus kolom lama dari profil seeker
        Schema::table('seeker_profiles', function (Blueprint $table) {
            $table->dropColumn('resume_path');
        });

        // Tambahkan kolom baru untuk menyimpan CV yang dipilih saat melamar
        Schema::table('job_applications', function (Blueprint $table) {
            $table->foreignId('cv_id')->nullable()->constrained()->after('seeker_profile_id');
        });
    }

    public function down(): void
    {
        // Logika untuk rollback jika diperlukan
        Schema::table('seeker_profiles', function (Blueprint $table) {
            $table->string('resume_path')->nullable();
        });

        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropForeign(['cv_id']);
            $table->dropColumn('cv_id');
        });
    }
};

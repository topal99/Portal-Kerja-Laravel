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
        // Kita ubah tipe kolom menjadi string dan set default baru
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('status')->default('Applied')->change();
        });
    }

    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            // Logika untuk rollback, kembalikan ke enum lama
            $table->enum('status', ['sent', 'viewed', 'rejected', 'accepted'])->default('sent')->change();
        });
    }
};

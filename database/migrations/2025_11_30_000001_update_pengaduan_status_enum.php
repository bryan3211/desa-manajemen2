<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum untuk status pengaduan
        Schema::table('pengaduan', function (Blueprint $table) {
            // MySQL: ubah enum
            DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status ENUM('pending', 'diproses', 'selesai', 'ditolak', 'revisi', 'belum_ditanggapi', 'sedang_ditangani') DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Revert ke enum lama
            DB::statement("ALTER TABLE pengaduan MODIFY COLUMN status ENUM('belum_ditanggapi', 'sedang_ditangani', 'selesai') DEFAULT 'belum_ditanggapi'");
        });
    }
};

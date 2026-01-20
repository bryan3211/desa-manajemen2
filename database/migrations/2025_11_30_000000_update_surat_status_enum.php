<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum untuk status_verifikasi
        Schema::table('surat', function (Blueprint $table) {
            // MySQL: ubah enum
            DB::statement("ALTER TABLE surat MODIFY COLUMN status_verifikasi ENUM('pending', 'diproses', 'selesai', 'ditolak', 'revisi', 'belum_verifikasi', 'sedang_diverifikasi', 'terverifikasi') DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('surat', function (Blueprint $table) {
            // Revert ke enum lama
            DB::statement("ALTER TABLE surat MODIFY COLUMN status_verifikasi ENUM('belum_verifikasi', 'sedang_diverifikasi', 'terverifikasi', 'ditolak') DEFAULT 'belum_verifikasi'");
        });
    }
};

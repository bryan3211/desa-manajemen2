<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Rename columns untuk match dengan model
            if (Schema::hasColumn('pengaduan', 'judul')) {
                $table->renameColumn('judul', 'judul_pengaduan');
            }
            if (Schema::hasColumn('pengaduan', 'deskripsi')) {
                $table->renameColumn('deskripsi', 'isi_pengaduan');
            }
            if (Schema::hasColumn('pengaduan', 'foto')) {
                $table->renameColumn('foto', 'bukti_lampiran');
            }
            if (Schema::hasColumn('pengaduan', 'lokasi')) {
                $table->renameColumn('lokasi', 'lokasi_kejadian');
            }
            if (Schema::hasColumn('pengaduan', 'tanggapan')) {
                $table->renameColumn('tanggapan', 'tanggapan_admin');
            }
            if (Schema::hasColumn('pengaduan', 'tanggapan_at')) {
                $table->renameColumn('tanggapan_at', 'tanggal_tanggapan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan', function (Blueprint $table) {
            // Revert column names
            if (Schema::hasColumn('pengaduan', 'judul_pengaduan')) {
                $table->renameColumn('judul_pengaduan', 'judul');
            }
            if (Schema::hasColumn('pengaduan', 'isi_pengaduan')) {
                $table->renameColumn('isi_pengaduan', 'deskripsi');
            }
            if (Schema::hasColumn('pengaduan', 'bukti_lampiran')) {
                $table->renameColumn('bukti_lampiran', 'foto');
            }
            if (Schema::hasColumn('pengaduan', 'lokasi_kejadian')) {
                $table->renameColumn('lokasi_kejadian', 'lokasi');
            }
            if (Schema::hasColumn('pengaduan', 'tanggapan_admin')) {
                $table->renameColumn('tanggapan_admin', 'tanggapan');
            }
            if (Schema::hasColumn('pengaduan', 'tanggal_tanggapan')) {
                $table->renameColumn('tanggal_tanggapan', 'tanggapan_at');
            }
        });
    }
};

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
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nomor_pengaduan')->unique();
            $table->enum('kategori', [
                'infrastruktur',
                'pelayanan_publik',
                'keamanan',
                'lingkungan',
                'sosial_kemasyarakatan',
                'lainnya'
            ])->default('lainnya');
            $table->string('judul');
            $table->longText('deskripsi');
            $table->string('foto')->nullable();
            $table->string('lokasi');
            $table->enum('status', ['belum_ditanggapi', 'sedang_ditangani', 'selesai'])->default('belum_ditanggapi');
            $table->text('tanggapan')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->timestamp('tanggapan_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};

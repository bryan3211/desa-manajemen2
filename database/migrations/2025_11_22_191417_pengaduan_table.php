<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop jenis_surat column jika ada, karena sudah diganti dengan kategori
        if (Schema::hasTable('pengaduan') && Schema::hasColumn('pengaduan', 'jenis_surat')) {
            Schema::table('pengaduan', function (Blueprint $table) {
                $table->dropColumn('jenis_surat');
            });
        }
    }

    public function down(): void
    {
        // Tidak ada aksi rollback karena ini opsional
    }
};

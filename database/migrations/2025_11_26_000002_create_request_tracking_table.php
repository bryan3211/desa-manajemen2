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
        Schema::create('request_tracking', function (Blueprint $table) {
            $table->id();
            $table->string('trackable_type'); // 'surat' or 'pengaduan'
            $table->unsignedBigInteger('trackable_id');
            $table->string('status'); // pending, diproses, selesai, ditolak
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable(); // admin who made the change
            $table->timestamps();
            
            // Foreign key
            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            
            // Indexes
            $table->index(['trackable_type', 'trackable_id']);
            $table->index('status');
            $table->index('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_tracking');
    }
};

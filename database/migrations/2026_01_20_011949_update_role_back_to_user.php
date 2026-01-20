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
        \DB::statement("UPDATE users SET role = 'user' WHERE role = 'warga'");
    }

    public function down(): void
    {
        \DB::statement("UPDATE users SET role = 'warga' WHERE role = 'user'");
    }
};

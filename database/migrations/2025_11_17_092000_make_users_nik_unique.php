<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure column allows NULLs (some installs may have created it as NOT NULL)
        try {
            DB::statement('ALTER TABLE `users` MODIFY `nik` VARCHAR(16) NULL');
        } catch (\Exception $e) {
            // ignore if ALTER fails (driver differences) and continue with normalization
        }

        // Normalize existing data: convert empty strings to NULL
        DB::table('users')->where('nik', '')->update(['nik' => null]);

        // Attempt to populate users.nik from biodata if available
        DB::table('users')
            ->leftJoin('biodata', 'users.id', '=', 'biodata.user_id')
            ->whereNull('users.nik')
            ->whereNotNull('biodata.nik')
            ->update(['users.nik' => DB::raw('biodata.nik')]);

        // Ensure remaining empty strings are NULL
        DB::table('users')->where('nik', '')->update(['nik' => null]);

        // Now add unique index (NULLs are allowed multiple times in MySQL)
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nik')) {
                return;
            }
            $table->unique('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            // Drop unique index if exists
            try {
                $table->dropUnique('users_nik_unique');
            } catch (\Exception $e) {
                // ignore if not exists
            }
        });
    }
};

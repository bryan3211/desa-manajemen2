<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // default role user
        // insert or update user 'User Satu'
        DB::table('users')->updateOrInsert(
            ['email' => 'usersatu@gmail.com'],
            [
                'name' => 'User Satu',
                'nik' => '1111222233334444',
                'password' => Hash::make('password123'),
                'avatar' => 'avatar-1.jpg',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $userId = DB::table('users')->where('email', 'usersatu@gmail.com')->value('id');

        DB::table('biodata')->updateOrInsert(
            ['user_id' => $userId],
            [
                'nik' => '1111222233334444',
                'nama_lengkap' => 'User Satu',
                'status_verifikasi' => 'belum_verifikasi',
                'kewarganegaraan' => 'WNI',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        // insert or update admin
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Satu',
                'role' => 'admin',
                'nik' => '9999888877776666',
                'password' => Hash::make('admin123'),
                'avatar' => 'admin-avatar.jpg',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $adminId = DB::table('users')->where('email', 'admin@gmail.com')->value('id');

        DB::table('biodata')->updateOrInsert(
            ['user_id' => $adminId],
            [
                'nik' => '9999888877776666',
                'nama_lengkap' => 'Admin Satu',
                'status_verifikasi' => 'terverifikasi',
                'kewarganegaraan' => 'WNI',
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
        // Note: Removed test NIK user to allow free registration
    }
}

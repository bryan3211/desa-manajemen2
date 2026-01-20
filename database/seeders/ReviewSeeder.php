<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return; // Skip if no users exist
        }

        $reviews = [
            [
                'comment' => 'Pelayanan jadi cepat dan data bisa dicek kapan pun. Warga senang, kerja lebih efisien.',
                'rating' => 5,
                'is_approved' => true,
                'user_id' => $users->first()->id,
            ],
            [
                'comment' => 'Laporan keuangan dan administrasi bisa langsung diakses oleh kepala desa.',
                'rating' => 5,
                'is_approved' => true,
                'user_id' => $users->skip(1)->first()->id ?? $users->first()->id,
            ],
            [
                'comment' => 'Cuma lewat HP, saya bisa ajukan surat domisili tanpa antre di kantor desa.',
                'rating' => 5,
                'is_approved' => true,
                'user_id' => $users->skip(2)->first()->id ?? $users->first()->id,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }
    }
}

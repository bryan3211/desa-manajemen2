<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agenda;
use App\Models\AgendaDocumentation;
use Illuminate\Support\Facades\DB;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'title' => 'Festival Budaya Desa 2025',
                'description' => 'Festival budaya tahunan yang menampilkan berbagai kesenian lokal, pertunjukan tradisional, pameran kerajinan tangan, dan kuliner tradisional. Acara ini dirancang untuk melestarikan warisan budaya desa dan memperkenalkannya kepada generasi muda.',
                'date_start' => now()->addDays(15)->setHour(8)->setMinute(0),
                'date_end' => now()->addDays(15)->setHour(18)->setMinute(0),
                'location' => 'Lapangan Desa Sentosa',
                'status' => 'upcoming',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Posyandu Kesehatan Ibu Hamil',
                'description' => 'Program pemeriksaan kesehatan gratis untuk ibu hamil yang diselenggarakan setiap bulan. Mencakup pemeriksaan tekanan darah, tes laboratorium, dan konsultasi dengan bidan desa. Pendaftaran gratis dan terbuka untuk semua ibu hamil di desa.',
                'date_start' => now()->subDays(2)->setHour(9)->setMinute(0),
                'date_end' => now()->subDays(2)->setHour(12)->setMinute(0),
                'location' => 'Balai Kesehatan Desa',
                'status' => 'done',
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Pelatihan Pertanian Organik',
                'description' => 'Workshop pelatihan tentang teknik bertani organik yang ramah lingkungan. Peserta akan belajar tentang pembuatan pupuk organik, pengendalian hama alami, dan pemilihan benih berkualitas. Materi praktik langsung di lahan demonstrasi.',
                'date_start' => now()->addHours(2)->setMinute(0),
                'date_end' => now()->addHours(6)->setMinute(0),
                'location' => 'Lahan Pertanian Komunitas',
                'status' => 'ongoing',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pengajian Rutin Bulanan',
                'description' => 'Pengajian keagamaan yang diikuti oleh seluruh masyarakat desa. Ceramah tentang nilai-nilai moral dan agama yang relevan dengan kehidupan sehari-hari. Dilanjutkan dengan diskusi terbuka dan tanya jawab.',
                'date_start' => now()->addDays(10)->setHour(19)->setMinute(0),
                'date_end' => now()->addDays(10)->setHour(21)->setMinute(0),
                'location' => 'Mushola Desa',
                'status' => 'upcoming',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Gotong Royong Pembersihan Desa',
                'description' => 'Kegiatan bersama untuk membersihkan lingkungan desa. Semua warga diajak berpartisipasi dalam membersihkan jalan, selokan, dan area publik lainnya. Kegiatan ini dilakukan secara berkala untuk menjaga kebersihan dan keindahan desa.',
                'date_start' => now()->addDays(7)->setHour(7)->setMinute(0),
                'date_end' => now()->addDays(7)->setHour(11)->setMinute(0),
                'location' => 'Seluruh Wilayah Desa',
                'status' => 'upcoming',
                'is_published' => false, // Draft
                'published_at' => null,
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        $this->command->info('Agenda seeder berhasil dijalankan!');
    }
}

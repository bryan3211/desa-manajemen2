@extends('layouts.landing')

@section('title', 'Selamat Datang di Sistem Informasi Desa')

@section('content')
<!-- [ Hero Section ] -->
<header id="home" class="d-flex align-items-center position-relative"
    style="min-height: 100dvh; background: linear-gradient(to bottom, rgba(15, 75, 15, 0.7), rgba(0, 0, 0, 0.3)), url('{{ asset('assets/images/my/desa-sid.png') }}') center/cover no-repeat;">
    <div class="container text-center text-white py-5">
        <h1 class="fw-bold display-4 mb-3 animate__animated animate__fadeInDown">
            <span class="text-white">Sistem Informasi</span> <span class="text-warning">Desa Digital</span>
        </h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">
            Transformasi digital untuk meningkatkan pelayanan publik dan transparansi pemerintahan desa.
        </p>
        <div class="mt-4 animate__animated animate__fadeInUp animate__delay-1s">
            <a href="{{ route('login') }}" class="btn btn-green btn-lg shadow-sm me-2">Masuk Sistem</a>
            <a href="#fitur" class="btn btn-outline-light btn-lg">Jelajahi Fitur</a>
        </div>
    </div>
</header>

<!-- [ Layanan Desa Modern - Grid Layout ] -->
<section id="layanan" class="py-5 bg-light">
    <div class="container text-center mb-5">
        <h5 class="text-success">Layanan Desa Modern</h5>
        <h2 class="fw-bold mb-3">Fitur Utama</h2>
        <p class="text-muted">Dukung administrasi dan pelayanan publik berbasis digital untuk desa yang lebih maju.</p>
    </div>

    <div class="container">
        <div class="row g-4">
            <!-- Fitur 1: Legalisasi Surat -->
            <div class="col-lg-6 mb-4">
                <div class="feature-card h-100" style="background: linear-gradient(135deg, #16a34a 0%, #0f7938 100%); border-radius: 24px; padding: 2.5rem; color: white; position: relative; overflow: hidden;">
                    <div class="position-absolute" style="top: -40px; right: -40px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center position-relative z-1">
                        <div class="col-md-7 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ti ti-document-check" style="font-size: 2rem; margin-right: 0.75rem;"></i>
                                <h4 class="fw-bold mb-0">Legalisasi Salinan Surat</h4>
                            </div>
                            
                            <p class="mb-3" style="opacity: 0.95;">
                                <strong>Persyaratan Pelayanan:</strong>
                            </p>
                            <ul class="text-start small" style="line-height: 1.8; opacity: 0.9;">
                                <li>Fotokopi dokumen yang akan dilegalisir</li>
                                <li>Bukti dokumen asli dari dokumen yang akan dilegalisasi</li>
                                <li>Sistem mekanisme verifikasi cepat...</li>
                            </ul>
                            
                            <a href="#" class="btn btn-light btn-sm mt-3" style="font-weight: 600;">Selengkapnya →</a>
                        </div>
                        <div class="col-md-5 text-end">
                            <img src="{{ asset('assets/images/my/surat-pernyataan.png') }}" alt="Surat" class="img-fluid rounded-3" style="max-width: 180px; opacity: 0.95;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fitur 2: Informasi Publik -->
            <div class="col-lg-6 mb-4">
                <div class="feature-card h-100" style="background: linear-gradient(135deg, #16a34a 0%, #0f7938 100%); border-radius: 24px; padding: 2.5rem; color: white; position: relative; overflow: hidden;">
                    <div class="position-absolute" style="top: -40px; right: -40px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center position-relative z-1">
                        <div class="col-md-7 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ti ti-folder-open" style="font-size: 2rem; margin-right: 0.75rem;"></i>
                                <h4 class="fw-bold mb-0">Informasi Publik</h4>
                            </div>
                            
                            <p class="mb-3" style="opacity: 0.95;">
                                <strong>Informasi Tersedia:</strong>
                            </p>
                            <ul class="text-start small" style="line-height: 1.8; opacity: 0.9;">
                                <li>Data struktur organisasi desa</li>
                                <li>Program kerja dan rencana pembangunan</li>
                                <li>Laporan pertanggungjawaban keuangan desa...</li>
                            </ul>
                            
                            <a href="#" class="btn btn-light btn-sm mt-3" style="font-weight: 600;">Selengkapnya →</a>
                        </div>
                        <div class="col-md-5 text-end">
                            <img src="{{ asset('assets/images/my/informasi-publik.png') }}" alt="Informasi" class="img-fluid rounded-3" style="max-width: 180px; opacity: 0.95;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fitur 3: Kartu Keluarga -->
            <div class="col-lg-6 mb-4">
                <div class="feature-card h-100" style="background: linear-gradient(135deg, #16a34a 0%, #0f7938 100%); border-radius: 24px; padding: 2.5rem; color: white; position: relative; overflow: hidden;">
                    <div class="position-absolute" style="top: -40px; right: -40px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center position-relative z-1">
                        <div class="col-md-7 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ti ti-id-badge-2" style="font-size: 2rem; margin-right: 0.75rem;"></i>
                                <h4 class="fw-bold mb-0">Kartu Keluarga (KK)</h4>
                            </div>
                            
                            <p class="mb-3" style="opacity: 0.95;">
                                <strong>Layanan KK Tersedia:</strong>
                            </p>
                            <ul class="text-start small" style="line-height: 1.8; opacity: 0.9;">
                                <li>Pembuatan Kartu Keluarga baru</li>
                                <li>Perubahan data karena pencatatan biodata</li>
                                <li>Penggantian Kartu Keluarga rusak...</li>
                            </ul>
                            
                            <a href="#" class="btn btn-light btn-sm mt-3" style="font-weight: 600;">Selengkapnya →</a>
                        </div>
                        <div class="col-md-5 text-end">
                            <img src="{{ asset('assets/images/my/kartu-keluarga.png') }}" alt="Kartu Keluarga" class="img-fluid rounded-3" style="max-width: 180px; opacity: 0.95;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fitur 4: Surat Domisili -->
            <div class="col-lg-6 mb-4">
                <div class="feature-card h-100" style="background: linear-gradient(135deg, #16a34a 0%, #0f7938 100%); border-radius: 24px; padding: 2.5rem; color: white; position: relative; overflow: hidden;">
                    <div class="position-absolute" style="top: -40px; right: -40px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                    
                    <div class="row align-items-center position-relative z-1">
                        <div class="col-md-7 text-start">
                            <div class="d-flex align-items-center mb-3">
                                <i class="ti ti-map-pin-check" style="font-size: 2rem; margin-right: 0.75rem;"></i>
                                <h4 class="fw-bold mb-0">Surat Domisili</h4>
                            </div>
                            
                            <p class="mb-3" style="opacity: 0.95;">
                                <strong>Persyaratan Umum:</strong>
                            </p>
                            <ul class="text-start small" style="line-height: 1.8; opacity: 0.9;">
                                <li>Fotokopi KTP atau identitas diri</li>
                                <li>Surat pengantar dari RT/RW</li>
                                <li>Bukti kepemilikan atau sewa rumah...</li>
                            </ul>
                            
                            <a href="#" class="btn btn-light btn-sm mt-3" style="font-weight: 600;">Selengkapnya →</a>
                        </div>
                        <div class="col-md-5 text-end">
                            <img src="{{ asset('assets/images/my/surat-domisili.png') }}" alt="Domisili" class="img-fluid rounded-3" style="max-width: 180px; opacity: 0.95;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- [ Alur Sistem ] -->
<section id="alur" class="py-5 bg-white">
    <div class="container text-center mb-5">
        <h5 class="text-success">Langkah Mudah</h5>
        <h2 class="fw-bold mb-3">Cara Menggunakan Sistem</h2>
        <p class="text-muted">Empat langkah cepat untuk memanfaatkan layanan desa digital.</p>
    </div>

    <div class="container">
        <div class="row g-4 justify-content-center">
            @php
                $steps = [
                    ['icon' => 'ti ti-user-check', 'title' => 'Login', 'desc' => 'Masuk menggunakan akun perangkat desa atau warga.'],
                    ['icon' => 'ti ti-file-text', 'title' => 'Isi Data', 'desc' => 'Lengkapi data sesuai kebutuhan layanan.'],
                    ['icon' => 'ti ti-shield-check', 'title' => 'Verifikasi', 'desc' => 'Data diverifikasi oleh perangkat desa.'],
                    ['icon' => 'ti ti-mail', 'title' => 'Selesai', 'desc' => 'Surat atau hasil layanan dapat diunduh langsung.']
                ];
            @endphp
            @foreach ($steps as $index => $step)
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 text-center py-4 hover-shadow h-100">
                        <i class="{{ $step['icon'] }} fs-1 text-success mb-3"></i>
                        <h5 class="fw-bold mb-2">{{ $loop->iteration }}. {{ $step['title'] }}</h5>
                        <p class="text-muted">{{ $step['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- [ CTA Section ] -->
<section class="position-relative text-center text-white"
    style="padding:100px 0; background:url('{{ asset('assets/images/my/bg-desa.png') }}') center/cover fixed;">
    <div class="overlay position-absolute top-0 bottom-0 start-0 end-0 bg-dark opacity-75"></div>
    <div class="container position-relative">
        <h2 class="fw-bold mb-3"> <span class="text-white">Siap Menjadi Desa</span> <span class="text-warning">Digital dan Transparan</span>?</h2>
        <p class="lead mb-4">Bangun tata kelola desa yang efektif dan melibatkan warga secara aktif.</p>
        <a href="{{ route('login') }}" class="btn btn-green btn-lg shadow-lg">Mulai Sekarang</a>
    </div>
</section>

<!-- [ Statistik ] -->
<section class="py-5" id="statistics-section">
    <div class="container text-center mb-5">
        <h5 class="text-light">Data Statistik</h5>
        <h2 class="fw-bold mb-3 text-light">Aktivitas Sistem Desa</h2>
    </div>
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-dark p-4 rounded-3 text-center h-100 border border-secondary">
                    <div class="stat-icon mb-3">
                        <i class="ti ti-users fs-1 text-light"></i>
                    </div>
                    <h6 class="text-light mb-3">Total Warga Terdaftar</h6>
                    <h2 class="text-light fw-bold stat-value" data-stat="total_users">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-dark p-4 rounded-3 text-center h-100 border border-secondary">
                    <div class="stat-icon mb-3">
                        <i class="ti ti-file-check fs-1 text-light"></i>
                    </div>
                    <h6 class="text-light mb-3">Total Pengajuan Surat</h6>
                    <h2 class="text-light fw-bold stat-value" data-stat="total_surats">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-dark p-4 rounded-3 text-center h-100 border border-secondary">
                    <div class="stat-icon mb-3">
                        <i class="ti ti-alert-circle fs-1 text-light"></i>
                    </div>
                    <h6 class="text-light mb-3">Total Laporan Masuk</h6>
                    <h2 class="text-light fw-bold stat-value" data-stat="total_pengaduans">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card-dark p-4 rounded-3 text-center h-100 border border-secondary">
                    <div class="stat-icon mb-3">
                        <i class="ti ti-message-circle fs-1 text-light"></i>
                    </div>
                    <h6 class="text-light mb-3">Total Ulasan</h6>
                    <h2 class="text-light fw-bold stat-value" data-stat="total_reviews">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Statistics Section Dark Theme */
    #statistics-section {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
        background-attachment: fixed;
        position: relative;
    }

    .stat-card-dark {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .stat-card-dark:hover {
        background: rgba(27, 163, 74, 0.15);
        border-color: #1ba34a !important;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(27, 163, 74, 0.2);
    }

    .stat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: rgba(27, 163, 74, 0.2);
        border-radius: 12px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .stat-card-dark:hover .stat-icon {
        background: rgba(27, 163, 74, 0.4);
        transform: scale(1.1);
    }
</style>

<!-- [ Testimoni ] -->
<section class="py-5">
    <div class="container text-center mb-5">
        <h5 class="text-success">Testimoni</h5>
        <h2 class="fw-bold mb-3">Pendapat Pengguna</h2>
        <p class="text-muted">Cerita sukses dari desa yang telah bertransformasi digital.</p>
    </div>

    <div class="container">
        <div class="row g-4">
            @forelse($reviews as $review)
            <div class="col-md-4">
                <div class="card testimonial-card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="d-flex align-items-start">
                        <img src="{{ filter_var($review->user->avatar, FILTER_VALIDATE_URL) ? $review->user->avatar : asset('assets/images/user/' . ($review->user->avatar ?? 'avatar-default.jpg')) }}" alt="{{ $review->user->name }}" class="wid-50 rounded-circle me-3 flex-shrink-0">
                        <div class="flex-grow-1 min-width-0">
                            <h5 class="mb-1 fw-semibold">{{ $review->user->name }}</h5>
                            <div class="mb-2">
                                {{ str_repeat('⭐', $review->rating) }}
                            </div>
                            <p class="text-muted">"{{ $review->comment }}"</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback to static testimonials if no reviews -->
            <div class="col-md-4">
                <div class="card testimonial-card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset('assets/images/user/khofifi.jpg') }}" alt="Khofifi" class="wid-50 rounded-circle me-3 flex-shrink-0">
                        <div class="flex-grow-1 min-width-0">
                            <h5 class="mb-1 fw-semibold">Khofifi Anhar</h5>
                            <small class="text-muted d-block mb-2">Kepala Desa Sukamaju</small>
                            <p class="text-muted">"Pelayanan jadi cepat dan data bisa dicek kapan pun. Warga senang, kerja lebih efisien."</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card testimonial-card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="Rina" class="wid-50 rounded-circle me-3 flex-shrink-0">
                        <div class="flex-grow-1 min-width-0">
                            <h5 class="mb-1 fw-semibold">Rina Kartika</h5>
                            <small class="text-muted d-block mb-2">Sekretaris Desa Mekarsari</small>
                            <p class="text-muted">"Laporan keuangan dan administrasi bisa langsung diakses oleh kepala desa."</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card testimonial-card shadow-sm border-0 rounded-4 p-3 h-100">
                    <div class="d-flex align-items-start">
                        <img src="{{ asset('assets/images/user/avatar-3.jpg') }}" alt="Siti" class="wid-50 rounded-circle me-3 flex-shrink-0">
                        <div class="flex-grow-1 min-width-0">
                            <h5 class="mb-1 fw-semibold">Siti Rahma</h5>
                            <small class="text-muted d-block mb-2">Warga Desa Cempaka</small>
                            <p class="text-muted">"Cuma lewat HP, saya bisa ajukan surat domisili tanpa antre di kantor desa."</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .stat-card:hover { background: #ecfdf5; transition: 0.3s ease; }

    /* Feature Card Styling */
    .feature-card {
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px rgba(15, 123, 56, 0.15);
        border: none !important;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(15, 123, 56, 0.25);
    }

    .feature-card .btn-light {
        transition: all 0.3s ease;
        border: none;
    }

    .feature-card .btn-light:hover {
        background-color: rgba(255, 255, 255, 0.9) !important;
        color: #0f7938 !important;
        transform: translateX(4px);
    }

    .feature-card h4 {
        font-size: 1.25rem;
        letter-spacing: -0.5px;
    }

    .feature-card ul li {
        position: relative;
        padding-left: 1rem;
    }

    .feature-card ul li:before {
        content: "✓";
        position: absolute;
        left: 0;
        font-weight: bold;
        opacity: 0.8;
    }

    /* Responsive Feature Cards */
    @media (max-width: 768px) {
        .feature-card {
            padding: 1.5rem !important;
        }

        .feature-card .row {
            flex-direction: column-reverse !important;
        }

        .feature-card img {
            max-width: 150px !important;
            margin: 1rem auto 0 !important;
        }

        .feature-card h4 {
            font-size: 1.1rem;
        }

        .feature-card .col-md-7,
        .feature-card .col-md-5 {
            width: 100% !important;
            text-align: center !important;
        }

        .feature-card ul {
            text-align: left !important;
            display: inline-block;
        }
    }

    /* Testimoni Card Responsive Styles */
    .testimonial-card {
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important;
    }

    .testimonial-card .d-flex {
        align-items: flex-start;
    }

    .testimonial-card img {
        min-width: 50px;
        object-fit: cover;
    }

    .testimonial-card h5 {
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .testimonial-card .text-muted {
        font-size: 0.8rem;
    }

    .testimonial-card p {
        font-size: 0.9rem;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        .testimonial-card {
            margin-bottom: 1.5rem;
            padding: 1.25rem !important;
        }

        .testimonial-card .d-flex {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
        }

        .testimonial-card img {
            margin-right: 0 !important;
            margin-bottom: 1rem;
            width: 50px !important;
            height: 50px !important;
        }

        .testimonial-card h5,
        .testimonial-card .text-muted {
            text-align: center;
        }

        .testimonial-card p {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .testimonial-card {
            padding: 1rem !important;
            margin-bottom: 1rem;
        }

        .testimonial-card .wid-50 {
            width: 44px !important;
            height: 44px !important;
        }

        .testimonial-card h5 {
            font-size: 0.9rem;
        }

        .testimonial-card small {
            font-size: 0.7rem !important;
        }

        .testimonial-card p {
            font-size: 0.8rem !important;
            line-height: 1.5;
        }

        /* Ensure content stays inside card */
        .testimonial-card {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .testimonial-card img {
            margin-bottom: 0.75rem !important;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .feature-card {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    @media (max-width: 576px) {
        .testimonial-card {
            padding: 1rem !important;
            margin-bottom: 1rem;
        }

        .testimonial-card .wid-50 {
            width: 44px !important;
            height: 44px !important;
        }

        .testimonial-card h5 {
            font-size: 0.9rem;
        }

        .testimonial-card small {
            font-size: 0.7rem !important;
        }

        .testimonial-card p {
            font-size: 0.8rem !important;
            line-height: 1.5;
        }

        /* Ensure content stays inside card */
        .testimonial-card {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .testimonial-card img {
            margin-bottom: 0.75rem !important;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .feature-card {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .feature-card:nth-child(2) { animation-delay: 0.2s; }
    .feature-card:nth-child(3) { animation-delay: 0.3s; }
    .feature-card:nth-child(4) { animation-delay: 0.4s; }

    /* Real-time Stats Animation */
    @keyframes pulse-number {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .stat-value.updated {
        animation: pulse-number 0.5s ease-in-out;
    }

    .spinner-border-sm {
        width: 1.5rem;
        height: 1.5rem;
    }
</style>

<script>
    // Fetch real-time statistics
    function fetchStatistics() {
        fetch('/api/statistics')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    updateStatistics(data.data);
                }
            })
            .catch(error => console.error('Error fetching statistics:', error));
    }

    // Update statistics on page
    function updateStatistics(stats) {
        const statKeys = {
            'total_users': stats.total_users,
            'total_surats': stats.total_surats,
            'total_pengaduans': stats.total_pengaduans,
            'total_reviews': stats.total_reviews,
        };

        for (const [key, value] of Object.entries(statKeys)) {
            const element = document.querySelector(`[data-stat="${key}"]`);
            if (element) {
                const currentValue = element.textContent.trim();
                
                // Remove spinner if exists
                const spinner = element.querySelector('.spinner-border');
                if (spinner) {
                    spinner.remove();
                }

                // Only update if value changed
                if (currentValue !== value.toString()) {
                    element.textContent = value;
                    element.classList.add('updated');
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        element.classList.remove('updated');
                    }, 500);
                } else if (!currentValue || currentValue.includes('spinner')) {
                    // Initial load
                    element.textContent = value;
                }
            }
        }
    }

    // Load statistics when page loads
    document.addEventListener('DOMContentLoaded', function() {
        fetchStatistics();
        
        // Refresh statistics every 10 seconds
        setInterval(fetchStatistics, 10000);
    });

    // Also track page visit
    function trackPageView() {
        fetch('/api/track-visitor', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                action: 'view',
                page: 'welcome'
            })
        }).catch(error => console.error('Error tracking visitor:', error));
    }

    document.addEventListener('DOMContentLoaded', trackPageView);
</script>

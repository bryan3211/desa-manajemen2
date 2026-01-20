{{-- FILE: resources/views/user/pengaduan/create.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Ajukan Pengaduan')

@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #fef8f0 0%, #fef3e2 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-message-circle me-2" style="font-size: 1.5rem; color: #d97706;"></i>
                <h5 class="mb-0 fw-bold">Pilih Kategori Pengaduan</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Pilih kategori yang sesuai dengan pengaduan Anda untuk melanjutkan</p>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('user.pengaduan.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Kategori Pengaduan (Bubble Selection) --}}
                <div class="row g-4 mb-5">
                    <!-- Infrastruktur -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="infrastruktur" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #f59e0b;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-building-communityti ti-tools"></i>
                                </div>
                                <h6 class="card-title fw-bold">Infrastruktur</h6>
                                <p class="card-text small text-muted">Jalan, Jembatan, Saluran Air</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pelayanan Publik -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="pelayanan_publik" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #3b82f6;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-building-community"></i>
                                </div>
                                <h6 class="card-title fw-bold">Pelayanan Publik</h6>
                                <p class="card-text small text-muted">Admin, Kesehatan, Pendidikan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Keamanan -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="keamanan" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #ef4444;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-alarm"></i>
                                </div>
                                <h6 class="card-title fw-bold">Keamanan</h6>
                                <p class="card-text small text-muted">Keselamatan & Ketentraman</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lingkungan -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="lingkungan" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #10b981;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-leaf"></i>
                                </div>
                                <h6 class="card-title fw-bold">Lingkungan</h6>
                                <p class="card-text small text-muted">Kebersihan & Kelestarian</p>
                            </div>
                        </div>
                    </div>

                    <!-- Sosial Kemasyarakatan -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="sosial_kemasyarakatan" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #8b5cf6;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-users"></i>
                                </div>
                                <h6 class="card-title fw-bold">Sosial Kemasyarakatan</h6>
                                <p class="card-text small text-muted">Kesejahteraan Masyarakat</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lainnya -->
                    <div class="col-md-6 col-lg-4">
                        <div class="kategori-bubble card h-100 text-decoration-none border-0 shadow-sm" data-kategori="lainnya" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #6b7280;">
                            <div class="card-body text-center p-4">
                                <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                    <i class="ti ti-dots-vertical"></i>
                                </div>
                                <h6 class="card-title fw-bold">Lainnya</h6>
                                <p class="card-text small text-muted">Kategori Lain</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hidden input untuk kategori yang dipilih --}}
                <input type="hidden" id="kategori" name="kategori" value="{{ old('kategori') }}" required>
                @error('kategori')
                    <div class="alert alert-danger mb-3">{{ $message }}</div>
                @enderror


                {{-- Tips Kategori --}}
                <div id="kategoriInfo" class="alert alert-info mb-4" style="display: none;">
                    <strong id="tipLabel"></strong>
                    <p id="tipContent" class="mb-0 mt-2"></p>
                </div>

                {{-- Card Form Pengaduan --}}
                <div class="card border-0 shadow-sm rounded-4" id="formContainer" style="display: none;">
                    <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
                        <h5 class="mb-0 fw-bold">
                            <i class="ti ti-document me-2"></i>Detail Pengaduan
                        </h5>
                    </div>
                    <div class="card-body">                        {{-- Judul Pengaduan --}}
                        <div class="form-group mb-4">
                            <label for="judul_pengaduan" class="form-label fw-bold">Judul Pengaduan <span class="text-danger">*</span></label>
                            <input type="text" id="judul_pengaduan" name="judul_pengaduan" class="form-control form-control-lg @error('judul_pengaduan') is-invalid @enderror" placeholder="Contoh akan muncul sesuai kategori" value="{{ old('judul_pengaduan') }}" required>
                            <small id="contohJudul" class="form-text text-muted"></small>
                            @error('judul_pengaduan')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Lokasi Kejadian --}}
                        <div class="form-group mb-4">
                            <label for="lokasi_kejadian" class="form-label fw-bold">Lokasi Kejadian <span class="text-danger">*</span></label>
                            <input type="text" id="lokasi_kejadian" name="lokasi_kejadian" class="form-control form-control-lg @error('lokasi_kejadian') is-invalid @enderror" placeholder="Lokasi akan muncul sesuai kategori" value="{{ old('lokasi_kejadian') }}" required>
                            <small id="contohLokasi" class="form-text text-muted"></small>
                            @error('lokasi_kejadian')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Isi Pengaduan --}}
                        <div class="form-group mb-4">
                            <label for="isi_pengaduan" class="form-label fw-bold">Isi Pengaduan <span class="text-danger">*</span></label>
                            <textarea id="isi_pengaduan" name="isi_pengaduan" class="form-control @error('isi_pengaduan') is-invalid @enderror" rows="7" placeholder="Jelaskan pengaduan sesuai kategori..." required>{{ old('isi_pengaduan') }}</textarea>
                            <small id="contohIsi" class="form-text text-muted"></small>
                            @error('isi_pengaduan')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Bukti Lampiran --}}
                        <div class="form-group mb-4">
                            <label for="bukti_lampiran" class="form-label fw-bold">Bukti Lampiran (Opsional)</label>
                            <div class="input-group input-group-lg">
                                <input type="file" id="bukti_lampiran" name="bukti_lampiran" class="form-control @error('bukti_lampiran') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <small class="form-text text-muted">Format: PDF, JPG, JPEG, PNG | Maksimal: 2MB</small>
                            @error('bukti_lampiran')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        {{-- Alert Info --}}
                        <div class="alert alert-info mb-4" role="alert">
                            <strong><i class="ti ti-info-circle me-2"></i>Informasi Penting:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Pengaduan akan diproses maksimal 3x24 jam kerja</li>
                                <li>Anda akan menerima notifikasi jika ada tanggapan dari admin</li>
                                <li>Pastikan data yang Anda berikan akurat dan lengkap</li>
                            </ul>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="ti ti-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="ti ti-send me-2"></i>Kirim Pengaduan
                            </button>
                        </div>
                    </div>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kategori-bubble {
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .kategori-bubble::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .kategori-bubble:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15) !important;
        }

        .kategori-bubble:hover::before {
            opacity: 1;
        }

        .kategori-bubble.active {
            box-shadow: 0 12px 30px rgba(79, 70, 229, 0.3) !important;
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-top-color: #4f46e5 !important;
        }

        .kategori-bubble.active .card-title {
            color: #4f46e5;
            font-weight: 700;
        }

        .kategori-bubble.active::after {
            content: '✓';
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        #formContainer {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control-lg {
            font-size: 1rem;
            height: 48px;
        }

        .btn-lg {
            padding: 12px 28px;
            font-size: 1rem;
            font-weight: 600;
        }
    </style>
</div>

{{-- JavaScript untuk bubble selection --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bubbles = document.querySelectorAll('.kategori-bubble');
    const kategoriInput = document.getElementById('kategori');
    const formContainer = document.getElementById('formContainer');
    const kategoriInfo = document.getElementById('kategoriInfo');
    const tipLabel = document.getElementById('tipLabel');
    const tipContent = document.getElementById('tipContent');
    const contohJudul = document.getElementById('contohJudul');
    const contohLokasi = document.getElementById('contohLokasi');
    const contohIsi = document.getElementById('contohIsi');
    const judulInput = document.getElementById('judul_pengaduan');
    const lokasiInput = document.getElementById('lokasi_kejadian');

    // Data template untuk setiap kategori
    const kategoriData = {
        infrastruktur: {
            label: ' Infrastruktur',
            info: 'Laporkan masalah infrastruktur seperti jalan berlubang, jembatan rusak, atau saluran air yang macet.',
            judulContoh: 'Contoh: "Jalan Raya Desa Berlubang Parah", "Jembatan Penghubung Rusak"',
            lokasiContoh: 'Contoh: "Jalan Raya Desa, KM 5", "Jembatan dekat Pasar Tradisional"',
            isiContoh: 'Contoh:\n• Jalan berlubang di beberapa titik\n• Lubang berukuran 20-30cm\n• Sering terjadi genangan air\n• Membahayakan pengguna jalan\n• Sudah berlangsung 2 bulan\n\nMohon segera dilakukan perbaikan.'
        },
        pelayanan_publik: {
            label: ' Pelayanan Publik',
            info: 'Laporkan masalah pelayanan publik seperti keterlambatan pelayanan, fasilitas kesehatan, atau pendidikan.',
            judulContoh: 'Contoh: "Pelayanan Administrasi Lambat", "Puskesmas Kurang Obat"',
            lokasiContoh: 'Contoh: "Kantor Desa", "Puskesmas Kelurahan"',
            isiContoh: 'Contoh:\n• Proses perizinan memakan waktu lama (lebih dari 2 minggu)\n• Petugas jarang berada di kantor\n• Tidak ada informasi yang jelas\n• Warga menjadi kesulitan\n\nMohon ditingkatkan kualitas pelayanan.'
        },
        keamanan: {
            label: ' Keamanan & Keselamatan',
            info: 'Laporkan masalah keamanan seperti pencurian, kerusuhan, atau bencana alam.',
            judulContoh: 'Contoh: "Pencuri Mencuri Ternak", "Ronda Malam Tidak Ada"',
            lokasiContoh: 'Contoh: "Perumahan di Jalan Merdeka", "Kawasan Pertanian Utara"',
            isiContoh: 'Contoh:\n• Sering terjadi pencurian di malam hari\n• Ronda malam tidak berjalan\n• Warga merasa takut\n• Sudah ada 3 kasus pencurian bulan ini\n• Perlu penambahan petugas keamanan\n\nMohon ditingkatkan keamanan.'
        },
        lingkungan: {
            label: ' Lingkungan & Kebersihan',
            info: 'Laporkan masalah lingkungan seperti sampah menumpuk, polusi, atau pohon tumbang.',
            judulContoh: 'Contoh: "Sampah Menumpuk di Jalan", "Pohon Besar Tumbang"',
            lokasiContoh: 'Contoh: "Jalan Utama Desa", "Taman Publik Desa"',
            isiContoh: 'Contoh:\n• Sampah tidak diangkut selama 1 minggu\n• Bau menyengat dari tumpukan sampah\n• Sudah menjadi sarang nyamuk\n• Mengganggu kesehatan warga\n• Tolong lebih sering diadakan pengangkutan sampah\n\nTerima kasih.'
        },
        sosial_kemasyarakatan: {
            label: 'Sosial Kemasyarakatan',
            info: 'Laporkan masalah sosial seperti konflik antar warga, keluarga tidak mampu, atau anak putus sekolah.',
            judulContoh: 'Contoh: "Konflik Antar Warga", "Anak Putus Sekolah"',
            lokasiContoh: 'Contoh: "RW 03 Desa", "Keluarga di Jalan Sejahtera"',
            isiContoh: 'Contoh:\n• Terjadi konflik antar tetangga\n• Sudah berlangsung cukup lama\n• Mengancam keharmonisan\n• Ada anak dari keluarga kurang mampu yang putus sekolah\n• Memerlukan bantuan sosial atau mediasi\n\nMohon bantuan dari pemerintah desa.'
        },
        lainnya: {
            label: ' Lainnya',
            info: 'Laporkan masalah lain yang tidak termasuk kategori di atas.',
            judulContoh: 'Contoh: "Masalah Lainnya yang Perlu Ditangani"',
            lokasiContoh: 'Contoh: Sesuaikan dengan lokasi masalah',
            isiContoh: 'Jelaskan masalah secara detail:\n• Apa yang terjadi\n• Kapan terjadi\n• Di mana terjadi\n• Siapa yang terlibat\n• Apa dampaknya\n• Solusi yang diharapkan'
        }
    };

    // Function untuk update kategori
    function updateKategori(selectedKategori) {
        if (!selectedKategori) return;

        // Update hidden input
        kategoriInput.value = selectedKategori;

        // Update bubbles
        bubbles.forEach(bubble => {
            if (bubble.dataset.kategori === selectedKategori) {
                bubble.classList.add('active');
            } else {
                bubble.classList.remove('active');
            }
        });

        // Update info & form
        if (kategoriData[selectedKategori]) {
            const data = kategoriData[selectedKategori];
            
            // Show kategori info
            kategoriInfo.style.display = 'block';
            tipLabel.textContent = data.label + ' - Tips:';
            tipContent.textContent = data.info;
            
            // Update placeholder & contoh
            judulInput.placeholder = data.judulContoh;
            contohJudul.textContent = data.judulContoh;
            
            lokasiInput.placeholder = data.lokasiContoh;
            contohLokasi.textContent = data.lokasiContoh;
            
            contohIsi.textContent = data.isiContoh;

            // Show form container
            formContainer.style.display = 'block';
        }
    }

    // Event listeners untuk bubble clicks
    bubbles.forEach(bubble => {
        bubble.addEventListener('click', function(e) {
            e.preventDefault();
            const selectedKategori = this.dataset.kategori;
            updateKategori(selectedKategori);
            
            // Scroll ke form
            setTimeout(() => {
                formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 100);
        });
    });

    // Load existing value jika ada
    if (kategoriInput.value) {
        updateKategori(kategoriInput.value);
    }
});
</script>
@endsection
@extends('layouts.dashboard')
@section('title','Buat Pengajuan Surat')
@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-file-text me-2" style="font-size: 1.5rem; color: #1ba34a;"></i>
                <h5 class="mb-0 fw-bold">Pilih Jenis Pengajuan Surat</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Pilih jenis surat yang ingin Anda ajukan untuk melanjutkan</p>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <!-- KTP -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'ktp') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #3b82f6;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-id"></i>
                            </div>
                            <h6 class="card-title fw-bold">Permohonan KTP</h6>
                            <p class="card-text small text-muted">Kartu Tanda Penduduk</p>
                        </div>
                    </a>
                </div>

                <!-- SKTM -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'sktm') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #10b981;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-file"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Tidak Mampu</h6>
                            <p class="card-text small text-muted">SKTM untuk Bantuan Sosial</p>
                        </div>
                    </a>
                </div>

                <!-- Domisili -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'domisili') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #f59e0b;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-home"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Domisili</h6>
                            <p class="card-text small text-muted">Surat Keterangan Domisili</p>
                        </div>
                    </a>
                </div>

                <!-- Izin Usaha -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'izin_usaha') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #ef4444;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-briefcase"></i>
                            </div>
                            <h6 class="card-title fw-bold">Izin Usaha</h6>
                            <p class="card-text small text-muted">Surat Izin Usaha Perdagangan</p>
                        </div>
                    </a>
                </div>

                <!-- KK/KIA -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'kk_kia') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #8b5cf6;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-users"></i>
                            </div>
                            <h6 class="card-title fw-bold">KK / KIA</h6>
                            <p class="card-text small text-muted">Kartu Keluarga / KIA</p>
                        </div>
                    </a>
                </div>

                <!-- Akta Kelahiran -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'akta_kelahiran') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #ec4899;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-heart"></i>
                            </div>
                            <h6 class="card-title fw-bold">Akta Kelahiran</h6>
                            <p class="card-text small text-muted">Pengurusan Akta Kelahiran</p>
                        </div>
                    </a>
                </div>

                <!-- Kelahiran -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'surat_kelahiran') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #20c997;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #20c997 0%, #13b981 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-file-plus"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Kelahiran</h6>
                            <p class="card-text small text-muted">Surat Keterangan Kelahiran</p>
                        </div>
                    </a>
                </div>

                <!-- Kematian -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'surat_kematian') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #6b7280;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-file-x"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Kematian</h6>
                            <p class="card-text small text-muted">Surat Keterangan Kematian</p>
                        </div>
                    </a>
                </div>

                <!-- Pindah/Mutasi -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'surat_pindah') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #17a2b8;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #17a2b8 0%, #0c5460 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-arrow-right"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Pindah</h6>
                            <p class="card-text small text-muted">Surat Pindah ke Desa Lain</p>
                        </div>
                    </a>
                </div>

                <!-- Izin Mendirikan Bangunan -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'izin_imb') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #f97316;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-building"></i>
                            </div>
                            <h6 class="card-title fw-bold">Izin Mendirikan Bangunan</h6>
                            <p class="card-text small text-muted">IMB / Surat Izin Bangunan</p>
                        </div>
                    </a>
                </div>

                <!-- Pembetulan Data -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'pembetulan_data') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #06b6d4;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-edit"></i>
                            </div>
                            <h6 class="card-title fw-bold">Pembetulan Data</h6>
                            <p class="card-text small text-muted">Permohonan Pembetulan Data</p>
                        </div>
                    </a>
                </div>

                <!-- Rekomendasi -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.surat.create.type', 'surat_rekomendasi') }}" class="card h-100 text-decoration-none border-0 shadow-sm" style="cursor: pointer; transition: all 0.3s ease; border-top: 4px solid #1ba34a;">
                        <div class="card-body text-center p-4">
                            <div class="mb-3" style="font-size: 2.5rem; background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                <i class="ti ti-certificate"></i>
                            </div>
                            <h6 class="card-title fw-bold">Surat Rekomendasi</h6>
                            <p class="card-text small text-muted">Surat Rekomendasi Umum</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            cursor: pointer;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(27, 163, 74, 0.15) !important;
        }
    </style>
</div>
@endsection

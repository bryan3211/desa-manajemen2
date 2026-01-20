@extends('layouts.dashboard')
@section('title', 'Biodata Saya')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Biodata</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Biodata Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="ti ti-info-circle me-2"></i>{{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Status Verifikasi -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">Status Verifikasi</h5>
                                <p class="text-muted mb-0">Data biodata Anda saat ini</p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <span class="badge bg-{{ $biodata->status_badge }} px-3 py-2 fs-6">
                                    {{ $biodata->status_label }}
                                </span>
                            </div>
                        </div>

                        @if($biodata->catatan_admin)
                            <hr>
                            <div class="alert alert-warning mb-0">
                                <h6 class="alert-heading">
                                    <i class="ti ti-message-circle me-2"></i>Catatan Admin
                                </h6>
                                <p class="mb-0">{{ $biodata->catatan_admin }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Biodata Detail -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Detail Biodata</h5>
                            {{-- Users are view-only; editing handled by admin --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Data Diri -->
                        <h6 class="border-bottom pb-2 mb-3">Data Diri</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">NIK</label>
                                    <p class="mb-0 fw-bold">{{ $biodata->nik }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Lengkap</label>
                                    <p class="mb-0 fw-bold">{{ $biodata->nama_lengkap }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Tempat, Tanggal Lahir</label>
                                    <p class="mb-0">{{ $biodata->tempat_lahir }}, {{ $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('d F Y') : '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Umur</label>
                                    <p class="mb-0">{{ $biodata->umur ?? '-' }} tahun</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Jenis Kelamin</label>
                                    @if($biodata->status_verifikasi == 'terverifikasi')
                                        <p class="mb-0">{{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    @else
                                        <p class="mb-0 text-muted"><em>Akan ditampilkan setelah verifikasi admin</em></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Agama</label>
                                    <p class="mb-0">{{ $biodata->agama ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Status Perkawinan</label>
                                    <p class="mb-0">{{ $biodata->status_perkawinan ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Pekerjaan</label>
                                    <p class="mb-0">{{ $biodata->pekerjaan ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Pendidikan Terakhir</label>
                                    <p class="mb-0">{{ $biodata->pendidikan_terakhir ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Kewarganegaraan</label>
                                    <p class="mb-0">{{ $biodata->kewarganegaraan }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Alamat</h6>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="text-muted small">Alamat Lengkap</label>
                                    <p class="mb-0">{{ $biodata->alamat_lengkap_format ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">No. HP</label>
                                    <p class="mb-0">{{ $biodata->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Email</label>
                                    <p class="mb-0">{{ $biodata->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Keluarga -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Data Keluarga</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Ayah</label>
                                    <p class="mb-0">{{ $biodata->nama_ayah ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Pekerjaan Ayah</label>
                                    <p class="mb-0">{{ $biodata->pekerjaan_ayah ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Nama Ibu</label>
                                    <p class="mb-0">{{ $biodata->nama_ibu ?? '-' }}</p>
                                </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Pekerjaan Ibu</label>
                                    <p class="mb-0">{{ $biodata->pekerjaan_ibu ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4">Dokumen</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Foto KTP</label>
                                    @if($biodata->foto_ktp)
                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_ktp) }}" target="_blank" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye me-1"></i>Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Belum upload</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Foto Kartu Keluarga</label>
                                    @if($biodata->foto_kk)
                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_kk) }}" target="_blank" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye me-1"></i>Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Belum upload</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-muted small d-block">Foto Diri</label>
                                    @if($biodata->foto_diri)
                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_diri) }}" target="_blank" 
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye me-1"></i>Lihat
                                        </a>
                                    @else
                                        <span class="text-muted">Belum upload</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($biodata->verified_by && $biodata->verified_at)
                            <hr class="my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted small">Diverifikasi oleh</label>
                                    <p class="mb-0">{{ $biodata->verifiedBy->name ?? 'Admin' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Tanggal Verifikasi</label>
                                    <p class="mb-0">{{ $biodata->verified_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
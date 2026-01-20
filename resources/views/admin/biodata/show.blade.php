@extends('layouts.dashboard')
@section('title', 'Detail Data Penduduk')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.biodata.index') }}">Kelola Data Penduduk</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Data Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Status -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">{{ $biodata->nama_lengkap }}</h5>
                                <p class="text-muted mb-0">NIK: {{ $biodata->nik }}</p>
                            </div>
                            <span class="badge bg-{{ $biodata->status_badge }} px-3 py-2">
                                {{ $biodata->status_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Detail Biodata -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Detail Lengkap</h5>
                    </div>
                    <div class="card-body">
                        <!-- Data Diri -->
                        <h6 class="border-bottom pb-2 mb-3 text-primary">
                            <i class="ti ti-user me-2"></i>Data Diri
                        </h6>
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
                                    <p class="mb-0">{{ $biodata->tempat_lahir ?? '-' }}, {{ $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('d F Y') : '-' }}</p>
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
                                    <p class="mb-0">{{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : ($biodata->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
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
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                            <i class="ti ti-map-pin me-2"></i>Alamat
                        </h6>
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
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                            <i class="ti ti-users me-2"></i>Data Keluarga
                        </h6>
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
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-muted small">Pekerjaan Ibu</label>
                                    <p class="mb-0">{{ $biodata->pekerjaan_ibu ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Dokumen -->
                        <h6 class="border-bottom pb-2 mb-3 mt-4 text-primary">
                            <i class="ti ti-file-upload me-2"></i>Dokumen
                        </h6>
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
                                    <label class="text-muted small d-block">Foto KK</label>
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

            <!-- Form Verifikasi -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Form Verifikasi</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.biodata.verify', $biodata->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                                <select class="form-control" name="status_verifikasi" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sedang_diverifikasi" {{ $biodata->status_verifikasi == 'sedang_diverifikasi' ? 'selected' : '' }}>
                                        Sedang Diverifikasi
                                    </option>
                                    <option value="terverifikasi" {{ $biodata->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>
                                        Terverifikasi
                                    </option>
                                    <option value="ditolak" {{ $biodata->status_verifikasi == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Admin</label>
                                <textarea class="form-control" name="catatan_admin" rows="4"
                                    placeholder="Berikan catatan jika diperlukan...">{{ old('catatan_admin', $biodata->catatan_admin) }}</textarea>
                                <small class="text-muted">Catatan akan dilihat oleh user</small>
                            </div>

                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>Pastikan data sudah benar sebelum memverifikasi.</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-check me-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.biodata.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar
                            </a>
                            <button type="button" class="btn btn-outline-info" onclick="window.print()">
                                <i class="ti ti-printer me-2"></i>Cetak Data
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
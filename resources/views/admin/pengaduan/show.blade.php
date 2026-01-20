@extends('layouts.dashboard')
@section('title', 'Detail Pengaduan')
@section('content')
<div class="pc-content">
    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pengaduan.index') }}">Kelola Pengaduan</a></li>
                        <li class="breadcrumb-item" aria-current="page">Detail</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="row">
        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Detail Pengaduan -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ $pengaduan->nomor_pengaduan }}</h5>
                            <p class="text-muted mb-0">Diterima: {{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="badge bg-{{ $pengaduan->status_badge }} px-3 py-2">
                            {{ $pengaduan->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Info Pengadu -->
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Informasi Pengadu</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Nama</p>
                            <p class="mb-0 fw-bold">{{ $pengaduan->user->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted mb-1">Email</p>
                            <p class="mb-0">{{ $pengaduan->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Pengaduan -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Detail Pengaduan</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted mb-1">Kategori</p>
                        <p class="mb-0">{{ ucwords(str_replace('_', ' ', $pengaduan->kategori)) }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted mb-1">Judul Pengaduan</p>
                        <p class="mb-0 fw-bold fs-5">{{ $pengaduan->judul_pengaduan }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted mb-1">Lokasi Kejadian</p>
                        <p class="mb-0">{{ $pengaduan->lokasi_kejadian }}</p>
                    </div>
                    <div class="mb-3">
                        <p class="text-muted mb-1">Isi Pengaduan</p>
                        <p class="mb-0">{!! nl2br(e($pengaduan->isi_pengaduan)) !!}</p>
                    </div>

                    @if($pengaduan->bukti_lampiran)
                        <div class="mb-3">
                            <p class="text-muted mb-1">Bukti Lampiran</p>
                            <a href="{{ asset('storage/pengaduan/' . $pengaduan->bukti_lampiran) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-download me-1"></i>Lihat Lampiran
                            </a>
                        </div>
                    @endif

                    @if($pengaduan->tanggapan_admin)
                        <hr>
                        <div class="alert alert-light border">
                            <h6>Tanggapan Admin Sebelumnya</h6>
                            <p>{!! nl2br(e($pengaduan->tanggapan_admin)) !!}</p>
                            <hr>
                            <small class="text-muted">
                                Oleh: {{ $pengaduan->admin->name ?? '-' }} | 
                                {{ $pengaduan->tanggal_tanggapan->format('d M Y H:i') }}
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Tanggapan -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Berikan Tanggapan</h6>
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

                    <form action="{{ route('admin.pengaduan.update', $pengaduan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Status Pengaduan <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" {{ $pengaduan->status=='pending' ? 'selected' : '' }}>Pending</option>
                                <option value="diproses" {{ $pengaduan->status=='diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ $pengaduan->status=='selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ $pengaduan->status=='ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggapan <span class="text-danger">*</span></label>
                            <textarea name="tanggapan_admin" class="form-control" rows="5" placeholder="Berikan tanggapan untuk pengaduan ini..." required>{{ old('tanggapan_admin', $pengaduan->tanggapan_admin) }}</textarea>
                            <small class="text-muted">Tanggapan akan dikirim ke email pengadu</small>
                        </div>

                        <div class="alert alert-info mb-3">
                            <i class="ti ti-info-circle me-2"></i>
                            <small>Pastikan tanggapan sudah sesuai sebelum disimpan</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-check me-2"></i>Simpan Tanggapan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Aksi Cepat</h6>
                </div>
                <div class="card-body d-grid gap-2">
                    <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="button" class="btn btn-outline-info" onclick="window.print()">
                        <i class="ti ti-printer me-2"></i>Cetak
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
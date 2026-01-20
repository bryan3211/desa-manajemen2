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
                            <li class="breadcrumb-item"><a href="{{ route('user.pengaduan.index') }}">Pengaduan</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Pengaduan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $pengaduan->nomor_pengaduan }}</h5>
                            <span class="badge bg-{{ $pengaduan->status_badge }}">{{ $pengaduan->status_label }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="text-muted mb-1">Jenis Surat</p>
                                <p class="mb-0 fw-bold">{{ $pengaduan->jenis_surat_label }}</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted mb-1">Tanggal Pengaduan</p>
                                <p class="mb-0 fw-bold">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <div class="col-sm-4">
                                <p class="text-muted mb-1">Status</p>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $pengaduan->status_badge }}">
                                        {{ $pengaduan->status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h6 class="text-muted">Judul Pengaduan</h6>
                            <p class="mb-0 fs-5 fw-bold">{{ $pengaduan->judul_pengaduan }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="text-muted">Isi Pengaduan</h6>
                            <p class="mb-0">{!! nl2br(e($pengaduan->isi_pengaduan)) !!}</p>
                        </div>

                        @if ($pengaduan->bukti_lampiran)
                            <div class="mb-3">
                                <h6 class="text-muted">Bukti Lampiran</h6>
                                <a href="{{ asset('storage/pengaduan/' . $pengaduan->bukti_lampiran) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-download me-2"></i>Lihat Lampiran
                                </a>
                            </div>
                        @endif

                        @if ($pengaduan->status != 'pending' && $pengaduan->tanggapan_admin)
                            <hr>
                            <div class="alert alert-light border">
                                <h6 class="alert-heading">
                                    <i class="ti ti-message-circle me-2"></i>Tanggapan Admin
                                </h6>
                                <p class="mb-2">{!! nl2br(e($pengaduan->tanggapan_admin)) !!}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <small class="text-muted">
                                            <i class="ti ti-user me-1"></i>
                                            Ditanggapi oleh: {{ $pengaduan->admin->name ?? 'Admin' }}
                                        </small>
                                    </div>
                                    <div class="col-sm-6 text-sm-end">
                                        <small class="text-muted">
                                            <i class="ti ti-clock me-1"></i>
                                            {{ $pengaduan->tanggal_tanggapan->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="ti ti-clock me-2"></i>
                                Pengaduan Anda sedang menunggu tanggapan dari admin. Mohon bersabar.
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-outline-secondary">
                                <i class="ti ti-arrow-left me-2"></i>Kembali
                            </a>
                            @if ($pengaduan->status == 'pending')
                                <form action="{{ route('user.pengaduan.destroy', $pengaduan->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="ti ti-trash me-2"></i>Hapus Pengaduan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
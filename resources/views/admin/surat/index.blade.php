@extends('layouts.dashboard')
@section('title','Kelola Pengajuan Surat')
@section('content')
<div class="pc-content">
    <!-- Breadcrumb -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Kelola Pengajuan Surat</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0">Kelola Pengajuan Surat</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-primary">
                                <i class="ti ti-file-text f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Total Pengajuan</h6>
                            <h4 class="mb-0">{{ $surats->total() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-warning">
                                <i class="ti ti-clock f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Belum Verifikasi</h6>
                            <h4 class="mb-0">{{ \App\Models\Surat::where('status_verifikasi', 'belum_verifikasi')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-info">
                                <i class="ti ti-refresh f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Sedang Diverifikasi</h6>
                            <h4 class="mb-0">{{ \App\Models\Surat::where('status_verifikasi', 'sedang_diverifikasi')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avtar avtar-s bg-light-success">
                                <i class="ti ti-check f-20"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Terverifikasi</h6>
                            <h4 class="mb-0">{{ \App\Models\Surat::where('status_verifikasi', 'terverifikasi')->count() }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pengajuan Surat</h5>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter -->
                    <form action="{{ route('admin.surat.index') }}" method="GET" class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <select class="form-control" name="status">
                                    <option value="">Semua Status</option>
                                    <option value="belum_verifikasi" {{ request('status') == 'belum_verifikasi' ? 'selected' : '' }}>
                                        Belum Verifikasi
                                    </option>
                                    <option value="sedang_diverifikasi" {{ request('status') == 'sedang_diverifikasi' ? 'selected' : '' }}>
                                        Sedang Diverifikasi
                                    </option>
                                    <option value="terverifikasi" {{ request('status') == 'terverifikasi' ? 'selected' : '' }}>
                                        Terverifikasi
                                    </option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="ti ti-search me-2"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.surat.index') }}" class="btn btn-outline-secondary">
                                        <i class="ti ti-refresh"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                    <th>Dikirim</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($surats as $s)
                                    <tr>
                                        <td><strong>#{{ $s->id }}</strong></td>
                                        <td>{{ $s->user?->email ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light-primary">
                                                {{ strtoupper($s->jenis_surat) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($s->status_verifikasi == 'belum_verifikasi')
                                                <span class="badge bg-light-warning">Belum Verifikasi</span>
                                            @elseif($s->status_verifikasi == 'sedang_diverifikasi')
                                                <span class="badge bg-light-info">Sedang Diverifikasi</span>
                                            @elseif($s->status_verifikasi == 'terverifikasi')
                                                <span class="badge bg-light-success">Terverifikasi</span>
                                            @elseif($s->status_verifikasi == 'ditolak')
                                                <span class="badge bg-light-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $s->created_at->format('d-m-Y H:i') }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.surat.show', $s->id) }}">
                                                <i class="ti ti-eye me-1"></i>Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="ti ti-inbox"></i> Tidak ada pengajuan surat
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Menampilkan {{ $surats->count() }} dari {{ $surats->total() }} pengajuan</span>
                        {{ $surats->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

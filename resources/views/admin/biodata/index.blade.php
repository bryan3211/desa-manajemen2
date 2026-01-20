@extends('layouts.dashboard')
@section('title', 'Kelola Data Penduduk')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Kelola BioData</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Kelola BioData</h2>
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
                                    <i class="ti ti-users f-20"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">Total Penduduk</h6>
                                <h4 class="mb-0">{{ $statistik['total'] }}</h4>
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
                                <h4 class="mb-0">{{ $statistik['belum_verifikasi'] }}</h4>
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
                                <h4 class="mb-0">{{ $statistik['sedang_diverifikasi'] }}</h4>
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
                                <h4 class="mb-0">{{ $statistik['terverifikasi'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Table -->
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
                            <h5 class="mb-0">Daftar Data Penduduk</h5>
                            <div>
                                <a href="{{ route('admin.biodata.create') }}" class="btn btn-primary btn-sm">
                                    <i class="ti ti-plus me-1"></i> Buat Biodata
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filter -->
                        <form action="{{ route('admin.biodata.index') }}" method="GET" class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select class="form-control" name="status">
                                        <option value="all">Semua Status</option>
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
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search" 
                                        placeholder="Cari NIK atau Nama..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-grow-1">
                                            <i class="ti ti-search me-2"></i>Cari
                                        </button>
                                        <a href="{{ route('admin.biodata.index') }}" class="btn btn-outline-secondary">
                                            <i class="ti ti-refresh"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NIK</th>
                                        <th>Nama Lengkap</th>
                                        <th>Tempat, Tgl Lahir</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($biodata as $item)
                                        <tr>
                                            <td><strong>{{ $item->nik }}</strong></td>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->tempat_lahir ?? '-' }}, {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                                            <td>{{ Str::limit($item->desa_kelurahan . ', ' . $item->kecamatan, 30) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $item->status_badge }}">
                                                    {{ $item->status_label }}
                                                </span>
                                            </td>
                                            <td class="d-flex gap-2">
                                                <a href="{{ route('admin.biodata.show', $item->id) }}"
                                                    class="btn btn-sm btn-icon btn-light-primary" title="Lihat">
                                                    <i class="ti ti-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.biodata.edit', $item->id) }}"
                                                    class="btn btn-sm btn-icon btn-light-warning" title="Edit">
                                                    <i class="ti ti-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.biodata.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus biodata ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-icon btn-light-danger" title="Hapus">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="ti ti-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                                <p class="text-muted mt-2">Tidak ada data penduduk</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $biodata->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
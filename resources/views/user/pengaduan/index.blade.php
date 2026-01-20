@extends('layouts.dashboard')
@section('title', 'Pengaduan Surat')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Pengaduan</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Pengaduan</h2>
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

                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Daftar Pengaduan Saya</h5>
                            <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary">
                                <i class="ti ti-plus me-2"></i>Ajukan Pengaduan Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($pengaduan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>No. Pengaduan</th>
                                            <th>Jenis Surat</th>
                                            <th>Judul</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pengaduan as $item)
                                            <tr>
                                                <td><strong>{{ $item->nomor_pengaduan }}</strong></td>
                                                <td>{{ $item->jenis_surat_label }}</td>
                                                <td>{{ Str::limit($item->judul_pengaduan, 50) }}</td>
                                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $item->status_badge }}">
                                                        {{ $item->status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.pengaduan.show', $item->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-primary">
                                                        <i class="ti ti-eye"></i>
                                                    </a>
                                                    @if ($item->status == 'pending')
                                                        <form action="{{ route('user.pengaduan.destroy', $item->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-icon btn-light-danger">
                                                                <i class="ti ti-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $pengaduan->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ti ti-inbox" style="font-size: 4rem; color: #ccc;"></i>
                                <h5 class="mt-3 text-muted">Belum ada pengaduan</h5>
                                <p class="text-muted">Anda belum pernah mengajukan pengaduan</p>
                                <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary mt-2">
                                    <i class="ti ti-plus me-2"></i>Ajukan Pengaduan Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
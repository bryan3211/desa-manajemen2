@extends('layouts.dashboard')
@section('title','Pengajuan Surat Saya')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Pengajuan Surat Saya</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Pengajuan Surat Saya</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Pengajuan</h5>
                        <a class="btn btn-primary" href="{{ route('user.surat.create') }}"><i class="ti ti-plus me-1"></i> Buat Pengajuan Baru</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Dikirim</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($surats as $s)
                                        <tr>
                                            <td>{{ $s->id }}</td>
                                            <td><strong>{{ strtoupper($s->jenis_surat) }}</strong></td>
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
                                                <a href="{{ route('user.surat.show', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="ti ti-eye me-1"></i>Lihat</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada pengajuan surat.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted">Menampilkan {{ $surats->count() }} dari {{ $surats->total() }} pengajuan</span>
                            {{ $surats->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

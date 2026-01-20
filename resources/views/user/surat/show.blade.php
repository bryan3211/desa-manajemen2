@extends('layouts.dashboard')
@section('title','Detail Pengajuan Surat #'.$surat->id)
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.surat.index') }}">Pengajuan Surat Saya</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Pengajuan Surat #{{ $surat->id }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">{{ strtoupper($surat->jenis_surat) }}</h5>
                            <p class="text-muted mb-0">Dikirim: {{ $surat->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                        <span class="badge bg-{{ $surat->status_verifikasi == 'terverifikasi' ? 'light-success' : ($surat->status_verifikasi == 'sedang_diverifikasi' ? 'light-info' : ($surat->status_verifikasi == 'ditolak' ? 'light-danger' : 'light-warning')) }} px-3 py-2">
                            {{ ucfirst(str_replace('_',' ',$surat->status_verifikasi)) }}
                        </span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Rincian Pengajuan</h5></div>
                    <div class="card-body">
                        @php $data = (array) $surat->data; @endphp
                        <div class="row">
                            @forelse($data as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">{{ ucwords(str_replace('_',' ',$key)) }}</label>
                                    @if(is_array($value))
                                        <pre class="mb-0">{{ json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        <p class="mb-0">{{ $value !== null && $value !== '' ? $value : '-' }}</p>
                                    @endif
                                </div>
                            @empty
                                <div class="col-12 text-muted">Tidak ada data pengajuan.</div>
                            @endforelse
                        </div>

                        @if($surat->attachment)
                            <hr class="my-4">
                            <div class="mb-3">
                                <a href="{{ asset('storage/surat/'.$surat->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ti ti-eye me-1"></i>Lihat Lampiran</a>
                            </div>
                        @endif

                        @if($surat->status_verifikasi != 'belum_verifikasi' && $surat->catatan_admin)
                            <hr class="my-4">
                            <div>
                                <label class="text-muted small d-block">Catatan Admin</label>
                                <p class="mb-0">{{ $surat->catatan_admin }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body d-grid gap-2">
                        <a href="{{ route('user.surat.index') }}" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-2"></i>Kembali</a>
                        @if($surat->status_verifikasi === 'terverifikasi')
                            <a href="{{ route('user.surat.print', $surat->id) }}" target="_blank" class="btn btn-outline-info"><i class="ti ti-printer me-2"></i>Cetak Data</a>
                        @else
                            <button class="btn btn-outline-secondary" disabled title="Surat belum diverifikasi admin"><i class="ti ti-printer me-2"></i>Cetak Data (Belum Diverifikasi)</button>
                        @endif
                        @if($surat->attachment)
                            <a href="{{ asset('storage/surat/'.$surat->attachment) }}" target="_blank" class="btn btn-outline-primary"><i class="ti ti-download me-2"></i>Download Lampiran</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

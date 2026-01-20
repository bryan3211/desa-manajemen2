@extends('layouts.dashboard', [
    'avatar' => $avatar,
    'name' => $name,
    'role' => $role,
    'unreadNotifications' => $unreadNotifications,
])

@section('title', 'Pelacakan Status Permohonan')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pelacakan Status</li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h2 class="mb-0"><i class="ti ti-location me-2"></i>Pelacakan Status Permohonan</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- SURAT SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="ti ti-file-text me-2" style="color: #1ba34a;"></i>Permohonan Surat</h5>
                        <span class="badge bg-primary">{{ $surats->count() }} Permohonan</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($surats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Jenis Surat</th>
                                        <th>Status</th>
                                        <th>Diajukan</th>
                                        <th>Update Terakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($surats as $surat)
                                        <tr>
                                            <td>
                                                <strong>{{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $surat->status_badge }}">
                                                    {{ $surat->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $surat->created_at->format('d M Y H:i') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $latestTracking = $surat->latestTracking();
                                                @endphp
                                                <small class="text-muted">
                                                    {{ $latestTracking ? $latestTracking->created_at->diffForHumans() : '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.tracking.surat', $surat->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ti ti-eye me-1"></i>Lihat Tracking
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Anda belum memiliki permohonan surat. <a href="{{ route('user.surat.create') }}">Buat permohonan baru</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PENGADUAN SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="ti ti-alert-circle me-2" style="color: #f97316;"></i>Permohonan Pengaduan</h5>
                        <span class="badge bg-warning">{{ $pengaduan->count() }} Permohonan</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($pengaduan->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                        <th>Update Terakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduan as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->nomor_pengaduan }}</strong>
                                            </td>
                                            <td>
                                                {{ \Illuminate\Support\Str::limit($item->judul_pengaduan, 50) }}
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $item->status_badge }}">
                                                    {{ $item->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $item->created_at->format('d M Y H:i') }}</small>
                                            </td>
                                            <td>
                                                @php
                                                    $latestTracking = $item->latestTracking();
                                                @endphp
                                                <small class="text-muted">
                                                    {{ $latestTracking ? $latestTracking->created_at->diffForHumans() : '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('user.tracking.pengaduan', $item->id) }}" class="btn btn-sm btn-info">
                                                    <i class="ti ti-eye me-1"></i>Lihat Tracking
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Anda belum memiliki permohonan pengaduan. <a href="{{ route('user.pengaduan.create') }}">Buat pengaduan baru</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>

<style>
    .page-header-title h2 {
        color: #1ba34a;
        font-weight: 700;
    }

    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(27, 163, 74, 0.08);
        border-radius: 12px;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(27, 163, 74, 0.15);
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
    }

    .btn-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
        border: none;
    }

    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(6, 182, 212, 0.3);
    }

    @media (max-width: 768px) {
        .page-header-title h2 {
            font-size: 24px;
        }

        .card-header {
            flex-direction: column;
            gap: 10px;
        }

        .card-header > div {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table {
            font-size: 12px;
        }

        .table th,
        .table td {
            padding: 8px 6px !important;
        }

        .btn-sm {
            padding: 4px 8px !important;
            font-size: 11px !important;
        }

        .badge {
            padding: 0.35rem 0.5rem;
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .page-header-title h2 {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .card-header {
            padding: 12px 15px !important;
        }

        .card-header h5 {
            font-size: 14px;
            margin-bottom: 8px;
        }

        .card-header .badge {
            align-self: flex-start;
        }

        .card-body {
            padding: 12px !important;
        }

        /* Mobile Table Stack */
        .table-responsive {
            border-radius: 6px;
            border: 1px solid #e8e8e8;
        }

        .table {
            font-size: 11px;
            margin-bottom: 0;
        }

        .table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e8e8e8;
        }

        .table th {
            padding: 10px 8px !important;
            font-size: 11px !important;
            font-weight: 600;
            white-space: nowrap;
        }

        .table td {
            padding: 10px 8px !important;
            word-break: break-word;
        }

        .table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-sm {
            padding: 5px 8px !important;
            font-size: 10px !important;
            white-space: nowrap;
        }

        .btn-sm i {
            margin-right: 0 !important;
            display: inline;
        }

        .btn-sm i + text,
        .btn-sm i + span {
            display: none;
        }

        .badge {
            padding: 0.3rem 0.4rem;
            font-size: 9px;
        }

        .alert {
            padding: 12px !important;
            font-size: 12px;
        }

        .alert i {
            margin-right: 6px;
        }

        small {
            font-size: 10px !important;
        }

        strong {
            font-weight: 600;
        }

        /* Horizontal scrolling for table on very small screens */
        @media (max-width: 400px) {
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 350px;
            }

            .btn-sm {
                padding: 4px 6px !important;
                font-size: 9px !important;
            }
        }
    }
</style>
@endsection

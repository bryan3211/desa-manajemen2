@extends('layouts.dashboard', [
    'avatar' => $avatar,
    'name' => $name,
    'role' => $role,
    'unreadNotifications' => $unreadNotifications,
])

@section('title', 'Tracking Surat')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.tracking.index') }}">Pelacakan</a></li>
                        <li class="breadcrumb-item active">Tracking Surat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <!-- Timeline Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="ti ti-timeline me-2"></i>Timeline Permohonan</h5>
                        <span class="badge bg-{{ $surat->status_badge }} fs-6">{{ $surat->status_label }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div id="trackingTimeline" class="timeline">
                        <!-- Will be populated by JavaScript -->
                        <div class="text-center text-muted py-5">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat riwayat tracking...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <!-- Info Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-info-circle me-2"></i>Detail Permohonan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted small mb-1">Jenis Surat</p>
                        <p class="fw-bold">{{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="text-muted small mb-1">Status Saat Ini</p>
                        <span class="badge bg-{{ $surat->status_badge }} fs-6 w-100 text-center py-2">
                            {{ $surat->status_label }}
                        </span>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="text-muted small mb-1">Diajukan</p>
                        <p class="fw-bold">{{ $surat->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="mb-3">
                        <p class="text-muted small mb-1">Update Terakhir</p>
                        <p class="fw-bold">
                            @php
                                $latest = $surat->latestTracking();
                            @endphp
                            {{ $latest ? $latest->created_at->format('d M Y H:i') : 'Belum ada' }}
                        </p>
                    </div>

                    @if($surat->latestTracking() && $surat->latestTracking()->notes)
                        <hr>
                        <div>
                            <p class="text-muted small mb-1">Catatan Terakhir</p>
                            <p class="text-sm">{{ $surat->latestTracking()->notes }}</p>
                        </div>
                    @endif

                    @if($surat->verifier)
                        <hr>
                        <div>
                            <p class="text-muted small mb-1">Admin Verifikasi</p>
                            <p class="fw-bold">{{ $surat->verifier->name }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Links -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('user.surat.show', $surat->id) }}" class="btn btn-outline-primary">
                            <i class="ti ti-eye me-1"></i>Lihat Detail Surat
                        </a>
                        <a href="{{ route('user.surat.index') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-list me-1"></i>Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>

<style>
    .timeline {
        position: relative;
        padding: 20px 0;
    }

    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        position: relative;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 50px;
        height: 60px;
        width: 2px;
        background: #e0e0e0;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        z-index: 1;
        flex-shrink: 0;
        margin-right: 20px;
        box-shadow: 0 4px 10px rgba(27, 163, 74, 0.3);
        transition: all 0.3s ease;
    }

    .timeline-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(27, 163, 74, 0.5);
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-time {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 5px;
    }

    .timeline-status {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .timeline-notes {
        font-size: 0.9rem;
        color: #666;
        margin-top: 8px;
        padding: 10px;
        background: #f8f9fa;
        border-left: 3px solid #1ba34a;
        border-radius: 4px;
    }

    .timeline-by {
        font-size: 0.85rem;
        color: #999;
    }

    @media (max-width: 768px) {
        .timeline {
            padding: 15px 0;
        }

        .timeline-item {
            margin-bottom: 20px;
        }

        .timeline-item::before {
            left: 12px;
            top: 45px;
            height: 50px;
        }

        .timeline-icon {
            width: 42px;
            height: 42px;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-time {
            font-size: 0.8rem;
        }

        .timeline-status {
            font-size: 0.95rem;
        }

        .timeline-notes {
            font-size: 0.85rem;
            padding: 8px;
            margin-top: 6px;
        }

        .card {
            margin-bottom: 12px;
        }

        .card-body {
            padding: 12px !important;
        }
    }

    @media (max-width: 576px) {
        .timeline {
            padding: 10px 0;
        }

        .timeline-item {
            margin-bottom: 16px;
            flex-direction: column;
        }

        .timeline-item::before {
            left: 10px;
            top: 40px;
            height: 40px;
        }

        .timeline-icon {
            width: 36px;
            height: 36px;
            font-size: 1rem;
            margin-right: 12px;
            margin-bottom: 0;
        }

        .timeline-content {
            padding-left: 0;
        }

        .timeline-time {
            font-size: 0.75rem;
        }

        .timeline-status {
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .timeline-notes {
            font-size: 0.8rem;
            padding: 6px;
            margin-top: 4px;
        }

        .card-header {
            flex-direction: column;
            gap: 8px;
        }

        .card-header .badge {
            align-self: flex-start;
        }

        .d-grid {
            gap: 8px !important;
        }

        .btn {
            font-size: 12px !important;
        }
    }
    
    .timeline-by {
        font-size: 0.85rem;
        color: #999;
        margin-top: 8px;
    }

    .card {
        border: none;
        box-shadow: 0 4px 15px rgba(27, 163, 74, 0.08);
        border-radius: 12px;
        margin-bottom: 20px;
    }

    .badge {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const suratId = {{ $surat->id }};
        const timelineContainer = document.getElementById('trackingTimeline');

        fetch(`/api/tracking/surat/${suratId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    let timelineHTML = '';
                    
                                    data.data.forEach((item, index) => {
                                        const badgeClass = `bg-${item.status_badge}`;
                                        const icon = item.status_icon;
                                        
                                        timelineHTML += `
                                            <div class="timeline-item">
                                                <div class="timeline-icon" title="${item.status_label}">
                                                    <span style="font-size: 1.3rem;">${icon}</span>
                                                </div>
                                                <div class="timeline-content">
                                                    <div class="timeline-time">
                                                        <i class="ti ti-clock me-1"></i>${item.timestamp_ago}
                                                    </div>
                                                    <div class="timeline-status">
                                                        <span class="badge ${badgeClass}" style="font-size: 0.9rem;">
                                                            ${icon} ${item.status_label}
                                                        </span>
                                                    </div>
                                                    ${item.notes ? `<div class="timeline-notes"><i class="ti ti-note me-1"></i>${item.notes}</div>` : ''}
                                                    <div class="timeline-by">
                                                        <i class="ti ti-user me-1"></i>Oleh: <strong>${item.updated_by}</strong> - ${item.timestamp}
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                                    });                    timelineContainer.innerHTML = timelineHTML;
                } else {
                    timelineContainer.innerHTML = `
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle me-2"></i>
                            Belum ada riwayat tracking untuk surat ini.
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                timelineContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-circle me-2"></i>
                        Gagal memuat riwayat tracking.
                    </div>
                `;
            });
    });
</script>
@endsection

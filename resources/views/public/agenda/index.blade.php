@extends('layouts.landing')

@section('title', 'Agenda Kegiatan Desa')

@section('content')
<div class="py-4" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="mb-5">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); 
                        border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="ti ti-calendar-event" style="font-size: 1.8rem; color: white;"></i>
                    </div>
                    <div class="ms-3">
                        <h1 class="h3 mb-0 fw-bold" style="color: #1f2937;">Agenda Kegiatan Desa</h1>
                        <small class="text-muted">Lihat jadwal kegiatan desa</small>
                    </div>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                @endauth
            </div>
        </div>

        <!-- Agendas Grid -->
        <div class="row g-4">
            @forelse ($agendas as $agenda)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('user.agenda.show', $agenda) }}" style="text-decoration: none; color: inherit;">
                        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden agenda-card" 
                            style="transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;">
                            
                            <!-- Image Section -->
                            <div style="position: relative; height: 200px; overflow: hidden; background: #e5e7eb;">
                                @if ($agenda->image)
                                    <img src="{{ asset('storage/' . $agenda->image) }}" 
                                        alt="{{ $agenda->title }}" 
                                        class="w-100 h-100 agenda-image" style="object-fit: cover; transition: transform 0.4s ease;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);">
                                        <i class="ti ti-calendar-event" style="font-size: 2.5rem; color: #9ca3af;"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div style="position: absolute; top: 12px; right: 12px;">
                                    <span class="badge bg-{{ $agenda->status_badge }}" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; font-weight: 600;">
                                        {{ $agenda->status_label }}
                                    </span>
                                </div>

                                <!-- Gradient Overlay -->
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.2), transparent); height: 50px;"></div>
                            </div>

                            <!-- Content Section -->
                            <div class="card-body pb-3">
                                <h6 class="card-title fw-bold mb-2" style="color: #1f2937; line-height: 1.4; height: 44px; overflow: hidden;">
                                    {{ Str::limit($agenda->title, 50) }}
                                </h6>

                                <!-- Info Section -->
                                <div style="border-top: 1px solid #e5e7eb; padding-top: 12px;">
                                    <div class="mb-2">
                                        <small class="text-muted d-flex align-items-center" style="gap: 0.5rem;">
                                            <i class="ti ti-calendar-event" style="font-size: 0.95rem; color: #f59e0b;"></i>
                                            <span>{{ $agenda->date_start->format('d M Y, H:i') }}</span>
                                        </small>
                                    </div>
                                    <small class="text-muted d-flex align-items-center" style="gap: 0.5rem;">
                                        <i class="ti ti-map-pin" style="font-size: 0.95rem; color: #16a34a;"></i>
                                        <span>{{ Str::limit($agenda->location, 30) }}</span>
                                    </small>
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div class="card-footer bg-white border-top px-3 py-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <small class="text-muted">Lihat detail</small>
                                    <i class="ti ti-arrow-right" style="color: #3b82f6; transition: transform 0.3s ease;"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
                        <i class="ti ti-inbox text-secondary mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted mb-2">Belum ada agenda kegiatan</h5>
                        <p class="text-muted small">Agenda akan ditampilkan di sini ketika ada kegiatan desa yang dijadwalkan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($agendas->hasPages())
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation" style="display: flex; gap: 0.5rem;">
                    {{ $agendas->links() }}
                </nav>
            </div>
        @endif
    </div>
</div>

<style>
    /* Card Hover Effects */
    .agenda-card {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08) !important;
    }

    .agenda-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12) !important;
    }

    .agenda-card:hover .agenda-image {
        transform: scale(1.08);
    }

    .agenda-card:hover .ti-arrow-right {
        transform: translateX(4px);
    }

    /* Badge styling */
    .badge {
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    /* Links */
    a {
        transition: all 0.3s ease;
    }

    /* Pagination */
    .pagination {
        gap: 0.25rem;
    }

    .pagination .page-link {
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: #f3f4f6;
        color: #3b82f6;
    }

    .pagination .page-item.active .page-link {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .h3 {
            font-size: 1.4rem !important;
        }

        .agenda-card {
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection

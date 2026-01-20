@extends('layouts.landing')

@section('title', $agenda->title)

@section('content')
<div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); min-height: 100vh; padding: 2rem 0;">
    <div class="container">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('user.agenda.index') }}" class="btn btn-sm btn-light" style="border-radius: 10px; border: 1px solid #e5e7eb;">
                <i class="ti ti-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Main Content -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <!-- Hero Image -->
            @if ($agenda->image)
                <div style="height: 350px; overflow: hidden; position: relative;">
                    <img src="{{ asset('storage/' . $agenda->image) }}" 
                        alt="{{ $agenda->title }}" 
                        class="w-100 h-100" style="object-fit: cover;">
                    
                    <!-- Status Badge -->
                    <div style="position: absolute; top: 20px; right: 20px;">
                        <span class="badge bg-{{ $agenda->status_badge }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                            {{ $agenda->status_label }}
                        </span>
                    </div>
                </div>
            @else
                <div style="height: 300px; background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%); 
                    display: flex; align-items: center; justify-content: center; position: relative;">
                    <i class="ti ti-image-off text-secondary" style="font-size: 4rem;"></i>
                    <div style="position: absolute; top: 20px; right: 20px;">
                        <span class="badge bg-{{ $agenda->status_badge }}" style="padding: 0.6rem 1rem; font-size: 0.9rem;">
                            {{ $agenda->status_label }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="card-body p-4">
                <!-- Title & Meta -->
                <h1 class="h2 fw-bold mb-2" style="color: #1f2937; line-height: 1.3;">{{ $agenda->title }}</h1>
                <p class="text-muted small mb-4">
                    <i class="ti ti-clock me-1"></i>Diposkan pada {{ $agenda->created_at->format('d M Y, H:i') }}
                </p>

                <!-- Key Information Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #eff6ff; border-left: 4px solid #3b82f6;">
                            <small class="text-muted d-block mb-1" style="font-weight: 600;">📅 Waktu Mulai</small>
                            <strong class="text-dark d-block">{{ $agenda->date_start->format('d M Y') }}</strong>
                            <small class="text-muted">{{ $agenda->date_start->format('H:i') }} WIB</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #fef3c7; border-left: 4px solid #f59e0b;">
                            <small class="text-muted d-block mb-1" style="font-weight: 600;">📍 Lokasi</small>
                            <strong class="text-dark d-block">{{ $agenda->location }}</strong>
                        </div>
                    </div>

                    @if ($agenda->date_end)
                    <div class="col-md-6">
                        <div class="p-3 rounded-3" style="background: #fee2e2; border-left: 4px solid #ef4444;">
                            <small class="text-muted d-block mb-1" style="font-weight: 600;">🕐 Waktu Selesai</small>
                            <strong class="text-dark d-block">{{ $agenda->date_end->format('d M Y') }}</strong>
                            <small class="text-muted">{{ $agenda->date_end->format('H:i') }} WIB</small>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3" style="color: #1f2937;">📝 Deskripsi Kegiatan</h5>
                    <div style="line-height: 1.8; color: #4b5563; font-size: 1rem; 
                        padding: 1.5rem; background: #f9fafb; border-radius: 12px; border-left: 4px solid #16a34a;">
                        {{ nl2br(e($agenda->description)) }}
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" onclick="window.print(); return false;" class="btn btn-sm btn-outline-secondary" style="border-radius: 10px;">
                        <i class="ti ti-printer me-2"></i>Cetak
                    </a>
                </div>
            </div>
        </div>

        <!-- Documentation Section -->
        @if ($agenda->status === 'done' && $documentations->count() > 0)
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom p-4" style="border-color: #e5e7eb !important;">
                <h5 class="mb-0 fw-bold" style="color: #1f2937;">
                    <i class="ti ti-photo me-2" style="color: #f59e0b;"></i>Galeri Dokumentasi
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach ($documentations as $doc)
                        <div class="col-md-6 col-lg-4">
                            <div class="position-relative overflow-hidden rounded-3 doc-container" style="height: 250px;">
                                <img src="{{ asset('storage/' . $doc->image_url) }}" 
                                    alt="Dokumentasi" 
                                    class="w-100 h-100 doc-image" style="object-fit: cover;">
                                
                                @if ($doc->caption)
                                    <div class="doc-caption position-absolute bottom-0 start-0 end-0 p-3" 
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); 
                                        color: white; opacity: 0; transition: opacity 0.3s ease;">
                                        <small style="font-size: 0.95rem;">{{ $doc->caption }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @elseif ($agenda->status === 'done')
        <div class="alert alert-info rounded-3 border-0 mb-0" style="background: #e0f2fe; color: #0369a1;">
            <i class="ti ti-info-circle me-2"></i>
            <strong>Dokumentasi belum tersedia</strong> - Dokumentasi kegiatan akan ditambahkan setelah proses verifikasi.
        </div>
        @else
        <div class="alert alert-warning rounded-3 border-0 mb-0" style="background: #fef3c7; color: #92400e;">
            <i class="ti ti-alert-circle me-2"></i>
            <strong>Dokumentasi akan tersedia setelah kegiatan selesai</strong>
        </div>
        @endif
    </div>
</div>

<style>
    /* Documentation hover effects */
    .doc-container:hover .doc-image {
        transform: scale(1.1);
    }

    .doc-container:hover .doc-caption {
        opacity: 1 !important;
    }

    .doc-image {
        transition: transform 0.3s ease;
    }

    .doc-caption {
        transition: opacity 0.3s ease;
    }

    /* Print styling */
    @media print {
        .btn, .alert, .d-flex.gap-2 {
            display: none !important;
        }

        body {
            background: white !important;
        }
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .h2 {
            font-size: 1.5rem !important;
        }

        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>
@endsection

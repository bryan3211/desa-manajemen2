@extends('layouts.dashboard')

@section('title', 'Detail Agenda')

@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #fef5e7 0%, #fef9f3 100%);">
    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold mb-1">{{ $agenda->title }}</h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $agenda->status_badge }}">{{ $agenda->status_label }}</span>
                        @if ($agenda->is_published)
                            <span class="badge bg-success">Dipublikasikan</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn btn-warning btn-sm">
                    <i class="ti ti-edit me-1"></i>Edit
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-4">
                    @if ($agenda->image)
                        <img src="{{ asset('storage/' . $agenda->image) }}" alt="{{ $agenda->title }}" 
                            class="img-fluid rounded" style="width: 100%; object-fit: cover; height: 250px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="ti ti-image-off" style="font-size: 3rem; color: #d1d5db;"></i>
                        </div>
                    @endif
                </div>

                <div class="col-lg-8">
                    <h6 class="fw-bold mb-3">Informasi Agenda</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">📅 Mulai</small>
                            <strong>{{ $agenda->date_start->format('d M Y H:i') }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">🕐 Selesai</small>
                            <strong>{{ $agenda->date_end?->format('d M Y H:i') ?? '-' }}</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted d-block">📍 Lokasi</small>
                            <strong>{{ $agenda->location }}</strong>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted d-block">📝 Dibuat</small>
                            <strong>{{ $agenda->created_at->format('d M Y') }}</strong>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-2">Deskripsi</h6>
                    <p>{{ $agenda->description }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dokumentasi Card -->
    @if ($agenda->status === 'done')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">📸 Galeri Dokumentasi</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal">
                    <i class="ti ti-plus me-1"></i>Tambah Foto
                </button>
            </div>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($agenda->documentations->count() > 0)
                <div class="row g-3">
                    @foreach ($agenda->documentations as $doc)
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <img src="{{ asset('storage/' . $doc->image_url) }}" 
                                    class="card-img-top" alt="Dokumentasi" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <p class="card-text">{{ $doc->caption ?? '-' }}</p>
                                    <form method="POST" action="{{ route('admin.agenda.deleteDocumentation', $doc) }}" 
                                        style="display: inline;" onsubmit="return confirm('Hapus foto ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="ti ti-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="ti ti-photo-off" style="font-size: 3rem; color: #d1d5db;"></i>
                    <p class="text-muted mt-2">Belum ada dokumentasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header border-bottom border-light">
                    <h5 class="modal-title fw-bold">Upload Dokumentasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form method="POST" action="{{ route('admin.agenda.uploadDocumentation', $agenda) }}" 
                    enctype="multipart/form-data">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Foto <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">JPG, PNG, GIF | Max 2MB</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <textarea name="caption" class="form-control" rows="3" 
                                placeholder="Tambahkan keterangan foto..."></textarea>
                        </div>
                    </div>

                    <div class="modal-footer border-top border-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-upload me-1"></i>Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-info">
        <i class="ti ti-info-circle me-2"></i>
        <strong>Info:</strong> Dokumentasi hanya dapat ditambahkan setelah kegiatan selesai (status: Selesai).
    </div>
    @endif

    <!-- Buttons -->
    <div class="mt-4">
        <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>
@endsection

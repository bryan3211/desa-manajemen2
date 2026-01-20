@extends('layouts.dashboard')

@section('title', 'Edit Agenda')

@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #fef5e7 0%, #fef9f3 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-edit me-2" style="font-size: 1.5rem; color: #f59e0b;"></i>
                <h5 class="mb-0 fw-bold">Edit Agenda</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Perbarui detail agenda kegiatan</p>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.agenda.update', $agenda) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Title -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Judul Agenda <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                placeholder="Contoh: Festival Budaya Desa" value="{{ old('title', $agenda->title) }}" required>
                            @error('title')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" rows="6" 
                                class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Jelaskan detail agenda kegiatan..." required>{{ old('description', $agenda->description) }}</textarea>
                            @error('description')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control form-control-lg @error('location') is-invalid @enderror" 
                                placeholder="Contoh: Lapangan Desa" value="{{ old('location', $agenda->location) }}" required>
                            @error('location')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Date Start -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="date_start" 
                                class="form-control form-control-lg @error('date_start') is-invalid @enderror" 
                                value="{{ old('date_start', $agenda->date_start->format('Y-m-d\TH:i')) }}" 
                                min="{{ now()->format('Y-m-d\TH:i') }}" required>
                            @error('date_start')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Date End -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Tanggal & Waktu Selesai (Opsional)</label>
                            <input type="datetime-local" name="date_end" 
                                class="form-control form-control-lg @error('date_end') is-invalid @enderror" 
                                value="{{ old('date_end', $agenda->date_end?->format('Y-m-d\TH:i')) }}" 
                                min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('date_end')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Image Upload -->
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold">Poster / Thumbnail (Opsional)</label>
                            <div class="border-2 border-dashed rounded p-4 text-center" style="border-color: #e5e7eb; cursor: pointer;" id="imageDropZone">
                                <input type="file" name="image" class="form-control d-none" id="imageInput" 
                                    accept="image/jpeg,image/png,image/jpg,image/gif" @error('image') is-invalid @enderror>
                                
                                <i class="ti ti-cloud-upload" style="font-size: 2.5rem; color: #f59e0b;"></i>
                                <p class="mt-2 mb-1 fw-bold">Pilih atau Drag gambar</p>
                                <small class="text-muted">JPG, PNG, GIF | Max 2MB</small>
                                
                                @if ($agenda->image)
                                    <img id="previewImage" src="{{ asset('storage/' . $agenda->image) }}" alt="Preview" class="mt-3 rounded" style="max-width: 100%;">
                                @else
                                    <img id="previewImage" src="" alt="Preview" class="mt-3 rounded" style="max-width: 100%; display: none;">
                                @endif
                            </div>
                            @error('image')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Status Info -->
                        <div class="alert alert-info">
                            <strong><i class="ti ti-info-circle me-2"></i>Status Saat Ini:</strong>
                            <p class="mb-0 mt-2">
                                <span class="badge bg-{{ $agenda->status_badge }} fs-6">
                                    {{ $agenda->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 justify-content-between mt-4">
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="ti ti-check me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image upload handlers
document.getElementById('imageDropZone').addEventListener('click', () => {
    document.getElementById('imageInput').click();
});

document.getElementById('imageInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('previewImage').src = event.target.result;
            document.getElementById('previewImage').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Drag and drop
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    document.getElementById('imageDropZone').addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    document.getElementById('imageDropZone').addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    document.getElementById('imageDropZone').addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    document.getElementById('imageDropZone').style.backgroundColor = '#fef3c7';
}

function unhighlight(e) {
    document.getElementById('imageDropZone').style.backgroundColor = 'transparent';
}

document.getElementById('imageDropZone').addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    document.getElementById('imageInput').files = files;
    
    const event = new Event('change', { bubbles: true });
    document.getElementById('imageInput').dispatchEvent(event);
}

// Date validation
const dateStartInput = document.querySelector('input[name="date_start"]');
const dateEndInput = document.querySelector('input[name="date_end"]');

dateStartInput.addEventListener('change', function() {
    const startDate = new Date(this.value);
    dateEndInput.min = this.value; // Set min to start date
    
    // If end date is before start date, clear it
    if (dateEndInput.value && new Date(dateEndInput.value) < startDate) {
        dateEndInput.value = '';
    }
});
</script>
@endsection

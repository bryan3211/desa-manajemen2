@extends('layouts.dashboard')

@section('title', 'Edit Ulasan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Ulasan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.ulasan.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-control @error('rating') is-invalid @enderror"
                                        id="rating" name="rating" required>
                                    <option value="">Pilih Rating</option>
                                    <option value="5" {{ old('rating', $review->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Bintang)</option>
                                    <option value="4" {{ old('rating', $review->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Bintang)</option>
                                    <option value="3" {{ old('rating', $review->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Bintang)</option>
                                    <option value="2" {{ old('rating', $review->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 Bintang)</option>
                                    <option value="1" {{ old('rating', $review->rating) == 1 ? 'selected' : '' }}>⭐ (1 Bintang)</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="comment" class="form-label">Komentar Ulasan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('comment') is-invalid @enderror"
                                  id="comment" name="comment" rows="5" required
                                  placeholder="Tuliskan pengalaman dan pendapat Anda tentang sistem ini...">{{ old('comment', $review->comment) }}</textarea>
                        @error('comment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    @if($review->is_approved)
                        <div class="alert alert-success">
                            <i class="ti ti-check-circle"></i>
                            <strong>Ulasan Disetujui:</strong> Ulasan ini sudah ditampilkan di halaman utama.
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="ti ti-info-circle"></i>
                            <strong>Informasi:</strong> Setelah diperbarui, ulasan ini akan langsung ditampilkan di halaman utama.
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Update Ulasan
                        </button>
                        <a href="{{ route('user.ulasan.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
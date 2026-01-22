@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Akta Kelahiran')
@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-heart me-2" style="font-size: 1.5rem; color: #ec4899;"></i>
                <h5 class="mb-0 fw-bold">Pengajuan Akta Kelahiran</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Lengkapi data anak untuk pengajuan akta kelahiran</p>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ $is_edit ? route('user.surat.update', $surat->id) : route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                @if($is_edit) @method('PUT') @endif
                <input type="hidden" name="jenis_surat" value="akta_kelahiran">

                <!-- Data Anak -->
                <div class="mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-info-circle me-2"></i>Data Anak
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Nama Anak <span class="text-danger">*</span></label>
                            <input type="text" name="nama_anak" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['nama_anak'] ?? '') : old('nama_anak') }}" placeholder="Nama lengkap anak" required>
                            @error('nama_anak') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ ($is_edit ? ($surat->data['jenis_kelamin'] ?? '') : old('jenis_kelamin')) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ ($is_edit ? ($surat->data['jenis_kelamin'] ?? '') : old('jenis_kelamin')) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['tempat_lahir'] ?? '') : old('tempat_lahir') }}" placeholder="Nama kota/kabupaten" required>
                            @error('tempat_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_lahir" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['tanggal_lahir'] ?? '') : old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Hari/Tanggal Melapor <span class="text-danger">*</span></label>
                            <input type="date" name="hari_melapor" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['hari_melapor'] ?? '') : old('hari_melapor') }}" required>
                            @error('hari_melapor') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Ibu -->
                <div class="mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-user-circle me-2"></i>Data Ibu
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Nama Ibu <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ibu" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['nama_ibu'] ?? '') : old('nama_ibu') }}" placeholder="Nama ibu kandung" required>
                            @error('nama_ibu') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">NIK Ibu</label>
                            <input type="text" name="nik_ibu" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['nik_ibu'] ?? '') : old('nik_ibu') }}" placeholder="16 digit NIK" maxlength="16">
                            @error('nik_ibu') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Ayah -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-user-circle me-2"></i>Data Ayah
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Nama Ayah <span class="text-danger">*</span></label>
                            <input type="text" name="nama_ayah" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['nama_ayah'] ?? '') : old('nama_ayah') }}" placeholder="Nama ayah kandung" required>
                            @error('nama_ayah') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">NIK Ayah</label>
                            <input type="text" name="nik_ayah" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ $is_edit ? ($surat->data['nik_ayah'] ?? '') : old('nik_ayah') }}" placeholder="16 digit NIK" maxlength="16">
                            @error('nik_ayah') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                rows="3" placeholder="Masukkan keterangan tambahan jika ada...">{{ $is_edit ? ($surat->data['keterangan'] ?? '') : old('keterangan') }}</textarea>
                            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Lampiran -->
                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: #1f2937;">Lampiran (opsional)</label>
                    <div class="input-group">
                        <input type="file" name="attachment" class="form-control rounded-start-3" style="border: 2px solid #e5e7eb;" 
                            accept=".pdf,.jpg,.jpeg,.png">
                        <span class="input-group-text bg-light" style="border: 2px solid #e5e7eb; border-left: none;">PDF / Foto (Max 5MB)</span>
                    </div>
                    @if($is_edit && $surat->attachment)
                        <small class="text-muted">File saat ini: {{ basename($surat->attachment) }}</small>
                    @endif
                    @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('user.surat.index') }}" class="btn btn-secondary rounded-3 px-4">
                        <i class="ti ti-arrow-left me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); color: white; border: none;">
                        <i class="ti ti-send me-2"></i>{{ $is_edit ? 'Update Pengajuan' : 'Kirim Pengajuan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

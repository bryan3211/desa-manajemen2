@extends('layouts.dashboard')
@section('title','Pengajuan Surat - KK/KIA')
@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-users me-2" style="font-size: 1.5rem; color: #8b5cf6;"></i>
                <h5 class="mb-0 fw-bold">Pengajuan KK / KIA</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Lengkapi data di bawah untuk mengajukan Kartu Keluarga atau KIA</p>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="kk_kia">

                <div class="row">
                    <!-- Jenis Dokumen -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Jenis Dokumen <span class="text-danger">*</span></label>
                        <select name="jenis_dokumen" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" required>
                            <option value="">-- Pilih Jenis Dokumen --</option>
                            <option value="KK" {{ old('jenis_dokumen') == 'KK' ? 'selected' : '' }}>Kartu Keluarga (KK)</option>
                            <option value="KIA" {{ old('jenis_dokumen') == 'KIA' ? 'selected' : '' }}>Kartu Identitas Anak (KIA)</option>
                        </select>
                        @error('jenis_dokumen')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Nomor KK -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Nomor KK</label>
                        <input type="text" name="nomor_kk" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            value="{{ old('nomor_kk') }}" placeholder="Contoh: 123456789012345">
                        @error('nomor_kk')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- NIK Kepala Keluarga -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">NIK Kepala Keluarga</label>
                        <input type="text" name="nik_kepala_keluarga" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            value="{{ old('nik_kepala_keluarga') }}" placeholder="16 digit NIK" maxlength="16">
                        @error('nik_kepala_keluarga')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Tujuan -->
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Tujuan Pengajuan <span class="text-danger">*</span></label>
                        <input type="text" name="tujuan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            value="{{ old('tujuan') }}" placeholder="Contoh: Sekolah, Paspor, dsb" required>
                        @error('tujuan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            rows="4" placeholder="Masukkan keterangan tambahan jika ada...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Lampiran -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Lampiran (opsional)</label>
                        <div class="input-group">
                            <input type="file" name="attachment" class="form-control rounded-start-3" style="border: 2px solid #e5e7eb;" 
                                accept=".pdf,.jpg,.jpeg,.png">
                            <span class="input-group-text bg-light" style="border: 2px solid #e5e7eb; border-left: none;">PDF / Foto (Max 5MB)</span>
                        </div>
                        @error('attachment')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('user.surat.index') }}" class="btn btn-secondary rounded-3 px-4">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); color: white; border: none;">
                        <i class="ti ti-send me-2"></i>Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Pembetulan Data')
@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-edit me-2" style="font-size: 1.5rem; color: #06b6d4;"></i>
                <h5 class="mb-0 fw-bold">Permohonan Pembetulan Data</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Ajukan permohonan untuk memperbaiki data yang salah atau tidak lengkap</p>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="pembetulan_data">

                <div class="alert alert-info rounded-3" style="background: rgba(6, 182, 212, 0.1); border: 1px solid #06b6d4; color: #0891b2;">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Informasi:</strong> Jelaskan dengan detail data mana yang perlu diperbaiki dan apa data yang benar.
                </div>

                <div class="row">
                    <!-- Jenis Data -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Jenis Data yang Perlu Diperbaiki <span class="text-danger">*</span></label>
                        <select name="jenis_data" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" required>
                            <option value="">-- Pilih Jenis Data --</option>
                            <option value="Nama" {{ old('jenis_data') == 'Nama' ? 'selected' : '' }}>Nama</option>
                            <option value="NIK" {{ old('jenis_data') == 'NIK' ? 'selected' : '' }}>NIK</option>
                            <option value="Tempat Lahir" {{ old('jenis_data') == 'Tempat Lahir' ? 'selected' : '' }}>Tempat Lahir</option>
                            <option value="Tanggal Lahir" {{ old('jenis_data') == 'Tanggal Lahir' ? 'selected' : '' }}>Tanggal Lahir</option>
                            <option value="Jenis Kelamin" {{ old('jenis_data') == 'Jenis Kelamin' ? 'selected' : '' }}>Jenis Kelamin</option>
                            <option value="Alamat" {{ old('jenis_data') == 'Alamat' ? 'selected' : '' }}>Alamat</option>
                            <option value="No. HP" {{ old('jenis_data') == 'No. HP' ? 'selected' : '' }}>No. HP</option>
                            <option value="Email" {{ old('jenis_data') == 'Email' ? 'selected' : '' }}>Email</option>
                            <option value="Agama" {{ old('jenis_data') == 'Agama' ? 'selected' : '' }}>Agama</option>
                            <option value="Status Perkawinan" {{ old('jenis_data') == 'Status Perkawinan' ? 'selected' : '' }}>Status Perkawinan</option>
                            <option value="Pekerjaan" {{ old('jenis_data') == 'Pekerjaan' ? 'selected' : '' }}>Pekerjaan</option>
                            <option value="Pendidikan" {{ old('jenis_data') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Lainnya" {{ old('jenis_data') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_data')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Data Lama -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Data Lama (Data yang Salah) <span class="text-danger">*</span></label>
                        <textarea name="data_lama" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            rows="3" placeholder="Tuliskan data yang saat ini terdaftar dan dianggap salah" required>{{ old('data_lama') }}</textarea>
                        @error('data_lama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Data Baru -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Data Baru (Data yang Benar) <span class="text-danger">*</span></label>
                        <textarea name="data_baru" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            rows="3" placeholder="Tuliskan data yang seharusnya benar" required>{{ old('data_baru') }}</textarea>
                        @error('data_baru')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Alasan Pembetulan -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Alasan Pembetulan <span class="text-danger">*</span></label>
                        <textarea name="alasan_pembetulan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            rows="4" placeholder="Jelaskan alasan mengapa perlu dilakukan pembetulan data ini. Sertakan bukti atau dokumen yang mendukung." required>{{ old('alasan_pembetulan') }}</textarea>
                        @error('alasan_pembetulan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Keterangan Tambahan -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Keterangan Tambahan</label>
                        <textarea name="keterangan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                            rows="3" placeholder="Tambahkan informasi lain jika ada...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Lampiran Bukti -->
                    <div class="col-12 mb-4">
                        <label class="form-label fw-bold" style="color: #1f2937;">Lampiran Bukti Pendukung (opsional)</label>
                        <div class="input-group">
                            <input type="file" name="attachment" class="form-control rounded-start-3" style="border: 2px solid #e5e7eb;" 
                                accept=".pdf,.jpg,.jpeg,.png" placeholder="Unggah surat/dokumen bukti">
                            <span class="input-group-text bg-light" style="border: 2px solid #e5e7eb; border-left: none;">PDF / Foto (Max 5MB)</span>
                        </div>
                        <small class="text-muted">Unggah dokumen pendukung seperti surat keterangan, foto, atau dokumen resmi lainnya</small>
                        @error('attachment')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning rounded-3 mt-4" style="background: rgba(245, 158, 11, 0.1); border: 1px solid #f59e0b; color: #92400e;">
                    <i class="ti ti-alert-triangle me-2"></i>
                    <strong>Perhatian:</strong> Pastikan data yang Anda kirim benar dan disertai bukti yang jelas. Pembetulan data akan diverifikasi oleh admin desa.
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('user.surat.index') }}" class="btn btn-secondary rounded-3 px-4">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border: none;">
                        <i class="ti ti-send me-2"></i>Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Izin Mendirikan Bangunan')
@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex align-items-center">
                <i class="ti ti-building me-2" style="font-size: 1.5rem; color: #f97316;"></i>
                <h5 class="mb-0 fw-bold">Pengajuan Izin Mendirikan Bangunan (IMB)</h5>
            </div>
            <p class="text-muted small mt-2 mb-0">Lengkapi data rencana bangunan Anda</p>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="izin_imb">

                <!-- Data Pemohon -->
                <div class="mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-user-circle me-2"></i>Data Pemohon
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Nama Pemohon <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pemohon" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('nama_pemohon') }}" placeholder="Nama lengkap" required>
                            @error('nama_pemohon') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">NIK Pemohon</label>
                            <input type="text" name="nik_pemohon" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('nik_pemohon') }}" placeholder="16 digit NIK" maxlength="16">
                            @error('nik_pemohon') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Lahan -->
                <div class="mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-map-pin me-2"></i>Data Lahan
                    </h6>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Alamat Lahan <span class="text-danger">*</span></label>
                            <textarea name="alamat_lahan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                rows="3" placeholder="Alamat lengkap lokasi lahan" required>{{ old('alamat_lahan') }}</textarea>
                            @error('alamat_lahan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Luas Tanah <span class="text-danger">*</span></label>
                            <input type="text" name="luas_tanah" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('luas_tanah') }}" placeholder="Contoh: 500 m²" required>
                            @error('luas_tanah') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Status Kepemilikan Lahan</label>
                            <input type="text" name="status_lahan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('status_lahan') }}" placeholder="Milik, Sewa, Hibah, dll">
                            @error('status_lahan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Rencana Bangunan -->
                <div class="mb-4 pb-3" style="border-bottom: 2px solid #e5e7eb;">
                    <h6 class="fw-bold mb-3" style="color: #1ba34a;">
                        <i class="ti ti-building me-2"></i>Rencana Bangunan
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Jenis Bangunan <span class="text-danger">*</span></label>
                            <input type="text" name="jenis_bangunan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('jenis_bangunan') }}" placeholder="Rumah Tinggal, Ruko, Gudang, dll" required>
                            @error('jenis_bangunan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Luas Bangunan <span class="text-danger">*</span></label>
                            <input type="text" name="luas_bangunan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                value="{{ old('luas_bangunan') }}" placeholder="Contoh: 300 m²" required>
                            @error('luas_bangunan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Fungsi Bangunan <span class="text-danger">*</span></label>
                            <textarea name="fungsi_bangunan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                rows="2" placeholder="Jelaskan fungsi bangunan yang akan dibangun" required>{{ old('fungsi_bangunan') }}</textarea>
                            @error('fungsi_bangunan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold" style="color: #1f2937;">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control rounded-3" style="border: 2px solid #e5e7eb;" 
                                rows="3" placeholder="Masukkan keterangan tambahan jika ada...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                <!-- Lampiran -->
                <div class="mb-4">
                    <label class="form-label fw-bold" style="color: #1f2937;">Lampiran (opsional - Denah, gambar rencana, dll)</label>
                    <div class="input-group">
                        <input type="file" name="attachment" class="form-control rounded-start-3" style="border: 2px solid #e5e7eb;" 
                            accept=".pdf,.jpg,.jpeg,.png">
                        <span class="input-group-text bg-light" style="border: 2px solid #e5e7eb; border-left: none;">PDF / Foto (Max 5MB)</span>
                    </div>
                    @error('attachment') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('user.surat.index') }}" class="btn btn-secondary rounded-3 px-4">
                        <i class="ti ti-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn rounded-3 px-4 fw-bold" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; border: none;">
                        <i class="ti ti-send me-2"></i>Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

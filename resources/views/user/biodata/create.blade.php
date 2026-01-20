@extends('layouts.dashboard')
@section('title', 'Lengkapi Biodata')
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Lengkapi Biodata</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Lengkapi Data Penduduk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="row">
            <div class="col-12">
                @if(isset($biodata))
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i>
                        <strong>Data NIK dan Nama Anda sudah tercatat saat registrasi.</strong> 
                        Silakan lengkapi data di bawah ini untuk kelengkapan data penduduk.
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h5>Form Biodata Penduduk</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ $biodata ? route('user.biodata.update') : route('user.biodata.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if($biodata)
                                @method('PUT')
                            @endif

                            @if(!Auth::user()->provider)
                            <!-- Data yang sudah ada (readonly) - Hanya untuk user registrasi biasa -->
                            <div class="row mb-4 p-3 bg-light rounded">
                                <div class="col-12">
                                    <h6 class="text-success mb-3">
                                        <i class="ti ti-check-circle me-2"></i>Data dari Registrasi
                                    </h6>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">NIK</label>
                                        <input type="text" class="form-control bg-white"
                                            value="{{ isset($biodata) ? $biodata->nik : Auth::user()->nik }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label fw-bold">Nama Lengkap</label>
                                        <input type="text" class="form-control bg-white"
                                            value="{{ isset($biodata) ? $biodata->nama_lengkap : Auth::user()->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Data yang perlu dilengkapi -->
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="border-bottom pb-2 mb-3 text-primary">
                                        <i class="ti ti-edit me-2"></i>Lengkapi Data Diri
                                    </h6>
                                </div>

                                @if(Auth::user()->provider)
                                <!-- Data Identitas untuk user SSO -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" 
                                            value="{{ old('nik', isset($biodata) ? $biodata->nik : '') }}" 
                                            placeholder="16 digit NIK" maxlength="16" required>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_lengkap" 
                                            value="{{ old('nama_lengkap', isset($biodata) ? $biodata->nama_lengkap : Auth::user()->name) }}" 
                                            placeholder="Nama lengkap sesuai KTP" required>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @else
                                <!-- Data Identitas untuk user biasa -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nik" 
                                            value="{{ old('nik', isset($biodata) ? $biodata->nik : Auth::user()->nik) }}" 
                                            placeholder="16 digit NIK" maxlength="16" required readonly>
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_lengkap" 
                                            value="{{ old('nama_lengkap', isset($biodata) ? $biodata->nama_lengkap : Auth::user()->name) }}" 
                                            placeholder="Nama lengkap sesuai KTP" required readonly>
                                        @error('nama_lengkap')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif

                                <!-- Data Kelahiran -->
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="tempat_lahir" 
                                            value="{{ old('tempat_lahir') }}" placeholder="Contoh: Jakarta" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="tanggal_lahir" 
                                            value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-control" name="jenis_kelamin" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Agama <span class="text-danger">*</span></label>
                                        <select class="form-control" name="agama" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Status Perkawinan <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status_perkawinan" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="pekerjaan" 
                                            value="{{ old('pekerjaan') }}" placeholder="Contoh: Pegawai Swasta" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Pendidikan Terakhir</label>
                                        <select class="form-control" name="pendidikan_terakhir">
                                            <option value="">-- Pilih --</option>
                                            <option value="SD" {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}>SMA</option>
                                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                                            <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                                            <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Data Alamat -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 mb-3 text-primary">
                                        <i class="ti ti-map-pin me-2"></i>Alamat Lengkap
                                    </h6>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="alamat_lengkap" rows="3" 
                                            placeholder="Contoh: Jl. Merdeka No. 123" required>{{ old('alamat_lengkap') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">RT <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="rt" 
                                            value="{{ old('rt') }}" placeholder="001" maxlength="3" required>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">RW <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="rw" 
                                            value="{{ old('rw') }}" placeholder="001" maxlength="3" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Desa/Kelurahan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="desa_kelurahan" 
                                            value="{{ old('desa_kelurahan') }}" placeholder="Contoh: Sukamaju" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kecamatan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="kecamatan" 
                                            value="{{ old('kecamatan') }}" placeholder="Contoh: Waru" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="kabupaten_kota" 
                                            value="{{ old('kabupaten_kota') }}" placeholder="Contoh: Sidoarjo" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Provinsi <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="provinsi" 
                                            value="{{ old('provinsi') }}" placeholder="Contoh: Jawa Timur" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Kode Pos <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="kode_pos" 
                                            value="{{ old('kode_pos') }}" placeholder="40123" maxlength="5" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">No. HP <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="no_hp" 
                                            value="{{ old('no_hp') }}" placeholder="08123456789" required>
                                    </div>
                                </div>

                                <!-- Data Keluarga -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 mb-3 text-primary">
                                        <i class="ti ti-users me-2"></i>Data Keluarga
                                    </h6>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Ayah <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_ayah" 
                                            value="{{ old('nama_ayah') }}" placeholder="Nama lengkap ayah" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Pekerjaan Ayah</label>
                                        <input type="text" class="form-control" name="pekerjaan_ayah" 
                                            value="{{ old('pekerjaan_ayah') }}" placeholder="Pekerjaan ayah">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama Ibu <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="nama_ibu" 
                                            value="{{ old('nama_ibu') }}" placeholder="Nama lengkap ibu" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Pekerjaan Ibu</label>
                                        <input type="text" class="form-control" name="pekerjaan_ibu" 
                                            value="{{ old('pekerjaan_ibu') }}" placeholder="Pekerjaan ibu">
                                    </div>
                                </div>

                                <!-- Upload Dokumen -->
                                <div class="col-12 mt-3">
                                    <h6 class="border-bottom pb-2 mb-3 text-primary">
                                        <i class="ti ti-file-upload me-2"></i>Upload Dokumen (Opsional)
                                    </h6>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Foto KTP</label>
                                        <input type="file" class="form-control" name="foto_ktp" accept="image/*">
                                        <small class="text-muted">Max 2MB (JPG, PNG)</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Foto Kartu Keluarga</label>
                                        <input type="file" class="form-control" name="foto_kk" accept="image/*">
                                        <small class="text-muted">Max 2MB (JPG, PNG)</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Foto Diri</label>
                                        <input type="file" class="form-control" name="foto_diri" accept="image/*">
                                        <small class="text-muted">Max 2MB (JPG, PNG)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning mt-3">
                                <i class="ti ti-alert-triangle me-2"></i>
                                <strong>Perhatian:</strong> Pastikan semua data yang Anda masukkan sudah benar. 
                                Data akan diverifikasi oleh admin desa.
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="ti ti-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-2"></i>Simpan Biodata
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validasi hanya angka untuk RT, RW, Kode Pos, No HP
        document.querySelectorAll('input[name="rt"], input[name="rw"], input[name="kode_pos"], input[name="no_hp"]').forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>
@endsection
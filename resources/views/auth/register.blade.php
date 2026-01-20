@extends('layouts.auth')

@section('title', 'Registrasi - Desa Digital')

@section('content')
@include('auth._theme')

<style>
    body {
        background: linear-gradient(135deg, #0f7938 0%, #1ba34a 50%, #0d5c2f 100%) !important;
        position: relative;
    }

    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.03)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,133.3C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat;
        pointer-events: none;
        z-index: 0;
    }

    .container {
        z-index: 1;
        position: relative;
    }

    .auth-card {
        border-radius: 24px !important;
        background: #ffffff;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        border: none;
        position: relative;
        overflow: hidden;
        margin: 3rem auto !important;
    }

    .auth-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #1ba34a 0%, #0f7938 100%);
    }

    /* Stepper Styles */
    .stepper-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3rem;
        position: relative;
        z-index: 2;
    }

    .stepper-container::before {
        content: '';
        position: absolute;
        top: 30px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
        z-index: -1;
    }

    .stepper-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        position: relative;
    }

    .stepper-circle {
        width: 60px;
        height: 60px;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #9ca3af;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .stepper-item.active .stepper-circle {
        background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%);
        border-color: #0f7938;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(27, 163, 74, 0.1);
    }

    .stepper-item.completed .stepper-circle {
        background: #1ba34a;
        border-color: #0f7938;
        color: #ffffff;
    }

    .stepper-item.completed .stepper-circle::after {
        content: '✓';
        font-size: 1.3rem;
    }

    .stepper-item.completed .stepper-circle span {
        display: none;
    }

    .stepper-label {
        margin-top: 0.75rem;
        font-weight: 600;
        font-size: 0.9rem;
        color: #6b7280;
        text-align: center;
        max-width: 100px;
    }

    .stepper-item.active .stepper-label {
        color: #1ba34a;
    }

    .stepper-item.completed .stepper-label {
        color: #0f7938;
    }

    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .section-title {
        display: flex;
        align-items: center;
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .section-title i {
        color: #1ba34a;
        font-size: 1.5rem;
        margin-right: 0.75rem;
    }

    .form-control {
        border-radius: 12px !important;
        border: 2px solid #e5e7eb !important;
        background: #f9fafb;
        height: 48px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #1ba34a !important;
        box-shadow: 0 0 0 3px rgba(27, 163, 74, 0.1) !important;
        background: #ffffff;
    }

    textarea.form-control {
        height: auto !important;
        min-height: 100px;
        resize: vertical;
    }

    .form-label {
        font-weight: 600;
        color: #1f2937;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }

    .form-label .text-danger {
        color: #dc2626;
        margin-left: 0.25rem;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6b7280;
        margin-top: 0.35rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%) !important;
        border: none !important;
        font-weight: 700;
        height: 56px;
        border-radius: 12px;
        font-size: 1.05rem;
        box-shadow: 0 10px 30px rgba(27, 163, 74, 0.2);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.2);
        transition: left 0.3s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 40px rgba(27, 163, 74, 0.3);
    }

    .btn-secondary {
        background: #e5e7eb !important;
        border: none !important;
        color: #1f2937 !important;
        font-weight: 700;
        height: 56px;
        border-radius: 12px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #d1d5db !important;
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-danger ul {
        padding-left: 1.5rem;
    }

    .alert-danger li {
        margin-bottom: 0.35rem;
    }

    .alert-info {
        background: #dbeafe;
        color: #1e40af;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-info i {
        margin-top: 0.1rem;
        flex-shrink: 0;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .button-group .btn {
        flex: 1;
        min-width: 140px;
    }

    .progress-info {
        text-align: center;
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #1ba34a;
        border-color: #0f7938;
    }

    .form-check-label {
        cursor: pointer;
        user-select: none;
    }

    .review-card {
        border-radius: 12px;
        background: #f3f4f6;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .stepper-label {
            max-width: 70px;
            font-size: 0.8rem;
        }

        .stepper-circle {
            width: 50px;
            height: 50px;
            font-size: 0.95rem;
        }

        .stepper-container {
            margin-bottom: 2.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .button-group .btn {
            width: 100%;
        }

        .auth-card {
            margin: 1rem auto !important;
            padding: 1.5rem !important;
        }

        .form-group {
            margin-bottom: 1rem !important;
        }

        .form-control,
        .form-select {
            padding: 0.6rem 0.75rem !important;
            font-size: 14px !important;
        }

        .form-label {
            font-size: 13px !important;
            margin-bottom: 6px !important;
        }

        .btn {
            padding: 0.6rem 1rem !important;
            font-size: 13px !important;
        }

        .review-card {
            padding: 1rem !important;
            margin-bottom: 1rem !important;
        }

        .alert {
            font-size: 12px !important;
            padding: 0.75rem !important;
        }
    }

    @media (max-width: 576px) {
        body {
            font-size: 12px;
        }

        .stepper-label {
            max-width: 60px;
            font-size: 0.7rem;
        }

        .stepper-circle {
            width: 44px;
            height: 44px;
            font-size: 0.85rem;
            line-height: 44px;
        }

        .stepper-container::before {
            height: 3px;
        }

        .stepper-item {
            margin: 0 5px;
        }

        .stepper-container {
            margin-bottom: 2rem;
            gap: 0;
        }

        .progress-info {
            font-size: 11px;
            margin-bottom: 1rem;
        }

        .auth-card {
            margin: 0.5rem auto !important;
            padding: 1rem !important;
            border-radius: 16px !important;
        }

        .auth-card.wide {
            max-width: 100% !important;
        }

        .form-group {
            margin-bottom: 0.75rem !important;
        }

        .form-control,
        .form-select {
            padding: 0.6rem 0.75rem !important;
            font-size: 13px !important;
            min-height: 44px;
            border-radius: 6px !important;
        }

        .form-label {
            font-size: 12px !important;
            margin-bottom: 4px !important;
            font-weight: 600;
        }

        .form-check {
            margin-bottom: 0.75rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
        }

        .form-check-label {
            font-size: 12px;
            margin-left: 8px;
        }

        .btn {
            padding: 0.6rem 0.8rem !important;
            font-size: 12px !important;
            width: 100%;
            margin-bottom: 6px;
            border-radius: 6px;
            min-height: 44px;
        }

        .btn:last-child {
            margin-bottom: 0;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .button-group .btn {
            width: 100%;
        }

        .review-card {
            padding: 0.75rem !important;
            margin-bottom: 0.75rem !important;
            border-radius: 8px;
        }

        .review-card h6 {
            font-size: 12px;
            margin-bottom: 6px;
        }

        .review-card p {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .alert {
            font-size: 11px !important;
            padding: 0.75rem !important;
            margin-bottom: 1rem !important;
            border-radius: 6px;
        }

        .alert ul {
            margin-bottom: 0;
            padding-left: 16px;
        }

        .alert li {
            margin-bottom: 4px;
        }

        hr {
            margin: 0.75rem 0 !important;
        }

        h5, h6 {
            font-size: 13px !important;
        }

        .text-muted {
            font-size: 11px !important;
        }

        small {
            font-size: 10px !important;
        }

        /* Horizontal scroll for better mobile experience */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .col-md-6 {
            flex: 0 0 calc(50% - 4px) !important;
        }

        @media (max-width: 400px) {
            .col-md-6 {
                flex: 0 0 100% !important;
            }

            .stepper-circle {
                width: 40px;
                height: 40px;
                font-size: 0.75rem;
                line-height: 40px;
            }

            .stepper-label {
                font-size: 0.65rem;
                max-width: 50px;
            }

            .button-group .btn {
                padding: 0.5rem !important;
                font-size: 11px !important;
            }
        }
    }
</style>

<div class="container">
    <div class="auth-card wide p-5" style="max-width: 900px;">
        <form id="registerForm" action="{{ route('register.post') }}" method="POST" novalidate>
            @csrf

            <!-- Stepper -->
            <div class="stepper-container">
                <div class="stepper-item active" data-step="1">
                    <div class="stepper-circle"><span>1</span></div>
                    <div class="stepper-label">Akun Login</div>
                </div>
                <div class="stepper-item" data-step="2">
                    <div class="stepper-circle"><span>2</span></div>
                    <div class="stepper-label">Data Diri</div>
                </div>
                <div class="stepper-item" data-step="3">
                    <div class="stepper-circle"><span>3</span></div>
                    <div class="stepper-label">Alamat</div>
                </div>
                <div class="stepper-item" data-step="4">
                    <div class="stepper-circle"><span>4</span></div>
                    <div class="stepper-label">Keluarga</div>
                </div>
                <div class="stepper-item" data-step="5">
                    <div class="stepper-circle"><span>5</span></div>
                    <div class="stepper-label">Selesai</div>
                </div>
            </div>

            <div class="progress-info">
                <span id="progressText">Langkah 1 dari 5</span>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Step 1: Data Akun Login -->
            <div class="form-section active" data-step="1">
                <div class="section-title">
                    <i class="ti ti-lock"></i>Data Akun Login
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" required name="email"
                                placeholder="email@example.com" value="{{ old('email') }}" autocomplete="off">
                            <small class="form-text">Email untuk login dan notifikasi</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" required name="password"
                                placeholder="Minimal 6 karakter" id="password">
                            <small class="form-text">Gunakan password yang aman</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" required name="password_confirmation"
                                placeholder="Ketik ulang password" id="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Tips Keamanan:</strong> Gunakan password yang terdiri dari kombinasi huruf, angka, dan simbol.
                    </div>
                </div>
            </div>

            <!-- Step 2: Data Diri -->
            <div class="form-section" data-step="2">
                <div class="section-title">
                    <i class="ti ti-user"></i>Data Diri
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="name"
                                placeholder="Nama sesuai KTP" value="{{ old('name') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" required name="nik"
                                placeholder="16 digit NIK"
                                value="{{ old('nik') }}"
                                maxlength="16"
                                pattern="[0-9]{16}"
                                autocomplete="off"
                                id="nik-input">
                            <small class="form-text">Digunakan untuk login dan identitas</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" name="tempat_lahir"
                                placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control" name="jenis_kelamin" required>
                                <option value="">- Pilih -</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Agama</label>
                            <select class="form-control" name="agama">
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
                            <label class="form-label">Status Perkawinan</label>
                            <select class="form-control" name="status_perkawinan">
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
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" name="pekerjaan"
                                placeholder="Contoh: Pegawai Swasta" value="{{ old('pekerjaan') }}">
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
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" name="no_hp"
                                placeholder="08123456789" value="{{ old('no_hp') }}">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Catatan:</strong> Field dengan tanda * wajib diisi. Field lainnya bersifat opsional dan dapat dilengkapi nanti.
                    </div>
                </div>
            </div>

            <!-- Step 3: Alamat -->
            <div class="form-section" data-step="3">
                <div class="section-title">
                    <i class="ti ti-map-pin"></i>Alamat
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" name="alamat_lengkap"
                                placeholder="Contoh: Jl. Merdeka No. 123">{{ old('alamat_lengkap') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">RT</label>
                            <input type="text" class="form-control" name="rt"
                                placeholder="001" value="{{ old('rt') }}" maxlength="3">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label">RW</label>
                            <input type="text" class="form-control" name="rw"
                                placeholder="001" value="{{ old('rw') }}" maxlength="3">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Desa/Kelurahan</label>
                            <input type="text" class="form-control" name="desa_kelurahan"
                                placeholder="Contoh: Sukamaju" value="{{ old('desa_kelurahan') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" name="kecamatan"
                                placeholder="Contoh: Waru" value="{{ old('kecamatan') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Kabupaten/Kota</label>
                            <input type="text" class="form-control" name="kabupaten_kota"
                                placeholder="Contoh: Sidoarjo" value="{{ old('kabupaten_kota') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" class="form-control" name="provinsi"
                                placeholder="Contoh: Jawa Timur" value="{{ old('provinsi') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" name="kode_pos"
                                placeholder="40123" value="{{ old('kode_pos') }}" maxlength="5">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Catatan:</strong> Data alamat bersifat opsional dan dapat dilengkapi nanti.
                    </div>
                </div>
            </div>

            <!-- Step 4: Keluarga -->
            <div class="form-section" data-step="4">
                <div class="section-title">
                    <i class="ti ti-users-group"></i>Data Keluarga
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Ayah</label>
                            <input type="text" class="form-control" name="nama_ayah"
                                placeholder="Nama ayah kandung" value="{{ old('nama_ayah') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Pekerjaan Ayah</label>
                            <input type="text" class="form-control" name="pekerjaan_ayah"
                                placeholder="Contoh: Petani" value="{{ old('pekerjaan_ayah') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control" name="nama_ibu"
                                placeholder="Nama ibu kandung" value="{{ old('nama_ibu') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label">Pekerjaan Ibu</label>
                            <input type="text" class="form-control" name="pekerjaan_ibu"
                                placeholder="Contoh: Ibu Rumah Tangga" value="{{ old('pekerjaan_ibu') }}">
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Catatan:</strong> Data keluarga bersifat opsional dan dapat dilengkapi nanti untuk keperluan administratif.
                    </div>
                </div>
            </div>

            <!-- Step 5: Konfirmasi & Selesai -->
            <div class="form-section" data-step="5">
                <div class="section-title">
                    <i class="ti ti-checkbox"></i>Konfirmasi & Selesai
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Informasi Penting:</strong> Pastikan semua data yang Anda isikan sudah benar sebelum menyelesaikan registrasi.
                    </div>
                </div>

                <div class="review-card">
                    <h6 class="fw-bold text-success mb-3">Data Registrasi Anda:</h6>
                    <div class="row small">
                        <div class="col-md-6 mb-2">
                            <strong class="text-muted">Email:</strong>
                            <span id="reviewEmail"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong class="text-muted">Nama:</strong>
                            <span id="reviewName"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong class="text-muted">NIK:</strong>
                            <span id="reviewNik"></span>
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong class="text-muted">No. HP:</strong>
                            <span id="reviewPhone"></span>
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                    <label class="form-check-label" for="agree">
                        Saya menyetujui <a href="#" class="text-primary">Syarat & Ketentuan</a> dan <a href="#" class="text-primary">Kebijakan Privasi</a>
                    </label>
                </div>

                <div class="alert alert-info">
                    <i class="ti ti-info-circle"></i>
                    <div>
                        <strong>Verifikasi Email:</strong> Setelah registrasi, kami akan mengirimkan link verifikasi ke email Anda untuk keamanan maksimal.
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="button-group">
                <button type="button" class="btn btn-secondary" id="prevBtn" style="display: none;">
                    <i class="ti ti-chevron-left me-2"></i>Kembali
                </button>
                <button type="button" class="btn btn-primary ms-auto" id="nextBtn">
                    Lanjutkan<i class="ti ti-chevron-right ms-2"></i>
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="display: none;">
                    <i class="ti ti-check me-2"></i>Selesaikan Registrasi
                </button>
            </div>

            <div class="text-center mt-3 small">
                Sudah punya akun? 
                <a href="/login" class="text-primary fw-bold">Masuk</a>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 5;

    // Debug helpers (temp) - capture JS errors and clicks
    window.addEventListener('error', function(e) {
        console.error('Global error:', e);
        // Don't spam users with alerts when not necessary; keep it for debugging
        try { alert('Terjadi error JavaScript: ' + (e.message || e)); } catch (err) {}
    });
    window.addEventListener('unhandledrejection', function(e) {
        console.error('Unhandled rejection:', e);
        try { alert('Unhandled promise rejection: ' + (e.reason && e.reason.message ? e.reason.message : e.reason)); } catch (err) {}
    });

    // Click logging for submit button
    const submitBtnElDbg = document.getElementById('submitBtn');
    if (submitBtnElDbg) {
        submitBtnElDbg.addEventListener('click', function() {
            console.log('submitBtn clicked, currentStep=', currentStep);
        });
    }

    // Validasi NIK hanya angka
    document.getElementById('nik-input').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Tombol Next
    document.getElementById('nextBtn').addEventListener('click', function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                goToStep(currentStep + 1);
            }
        }
    });

    // Tombol Prev
    document.getElementById('prevBtn').addEventListener('click', function() {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    // Tombol Submit - Validasi semua step sebelum submit
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        try {
            console.log('registerForm submit handler invoked, currentStep=', currentStep);

            // Validate all steps in order; if any invalid, go to that step and prevent submit
            for (let s = 1; s <= totalSteps; s++) {
                if (!validateStep(s)) {
                    e.preventDefault();
                    goToStep(s);

                    // Re-enable submit button if a handler disabled it (UX safety)
                    const sb = document.getElementById('submitBtn');
                    if (sb) {
                        setTimeout(() => {
                            sb.disabled = false;
                            sb.innerHTML = '<i class="ti ti-check me-2"></i>Selesaikan Registrasi';
                        }, 0);
                    }

                    return false;
                }
            }

            // All steps valid — disable submit button to avoid double submission
            const sb = document.getElementById('submitBtn');
            if (sb) {
                sb.disabled = true;
                sb.innerHTML = 'Mengirim...';
            }
        } catch (err) {
            console.error('submit handler error', err);
            try { alert('Terjadi error pada proses pengiriman: ' + (err.message || err)); } catch (e) {}
            if (typeof e.preventDefault === 'function') e.preventDefault();
            const sb = document.getElementById('submitBtn');
            if (sb) {
                sb.disabled = false;
                sb.innerHTML = '<i class="ti ti-check me-2"></i>Selesaikan Registrasi';
            }
            return false;
        }
    });

    // Validasi Step
    function validateStep(step) {
        const form = document.getElementById('registerForm');
        const inputs = form.querySelectorAll(`.form-section[data-step="${step}"] input[required], .form-section[data-step="${step}"] select[required]`);
        
        let isValid = true;
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                // Untuk checkbox
                if (!input.checked) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            } else {
                // Untuk input text, email, select, dll
                if (!input.value.trim()) {
                    input.focus();
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            }
        });

        // Validasi email format
        if (step === 1) {
            const email = form.querySelector('input[name="email"]');
            const password = form.querySelector('input[name="password"]');
            const passwordConfirm = form.querySelector('input[name="password_confirmation"]');

            if (email && !email.value.includes('@')) {
                email.classList.add('is-invalid');
                isValid = false;
            }

            if (password && passwordConfirm && password.value !== passwordConfirm.value) {
                passwordConfirm.classList.add('is-invalid');
                alert('Password dan konfirmasi password tidak sesuai');
                isValid = false;
            }

            if (password && password.value.length < 6) {
                password.classList.add('is-invalid');
                alert('Password minimal 6 karakter');
                isValid = false;
            }
        }

        // Validasi NIK
        if (step === 2) {
            const nik = form.querySelector('input[name="nik"]');
            if (nik && nik.value.length !== 16) {
                nik.classList.add('is-invalid');
                alert('NIK harus 16 digit');
                isValid = false;
            }
        }

        // Validasi Checkbox Agreement di Step 5
        if (step === 5) {
            const agree = form.querySelector('input#agree');
            if (agree && !agree.checked) {
                agree.classList.add('is-invalid');
                alert('Anda harus menyetujui Syarat & Ketentuan dan Kebijakan Privasi');
                isValid = false;
            } else if (agree) {
                agree.classList.remove('is-invalid');
            }
        }

        return isValid;
    }

    // Pindah ke step tertentu
    function goToStep(step) {
        // Sembunyikan semua section
        document.querySelectorAll('.form-section').forEach(section => {
            section.classList.remove('active');
        });

        // Tampilkan section aktif
        document.querySelector(`.form-section[data-step="${step}"]`).classList.add('active');

        // Update stepper
        document.querySelectorAll('.stepper-item').forEach((item, index) => {
            item.classList.remove('active', 'completed');
            if (index + 1 < step) {
                item.classList.add('completed');
            } else if (index + 1 === step) {
                item.classList.add('active');
            }
        });

        // Update buttons
        document.getElementById('prevBtn').style.display = step > 1 ? 'block' : 'none';
        document.getElementById('nextBtn').style.display = step < totalSteps ? 'block' : 'none';
        document.getElementById('submitBtn').style.display = step === totalSteps ? 'block' : 'none';

        // Update progress text
        document.getElementById('progressText').textContent = `Langkah ${step} dari ${totalSteps}`;

        // Update preview di step 5 (final review)
        if (step === 5) {
            const form = document.getElementById('registerForm');
            document.getElementById('reviewEmail').textContent = form.querySelector('input[name="email"]').value;
            document.getElementById('reviewName').textContent = form.querySelector('input[name="name"]').value;
            document.getElementById('reviewNik').textContent = form.querySelector('input[name="nik"]').value;
            document.getElementById('reviewPhone').textContent = form.querySelector('input[name="no_hp"]').value || '-';
        }

        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection

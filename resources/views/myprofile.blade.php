{{-- FILE: resources/views/myprofile.blade.php --}}
@extends('layouts.dashboard', [
    'avatar' => $avatar,
    'name' => $name,
    'role' => $role,
    'unreadNotifications' => $unreadNotifications,
])

@section('title', 'My Profile')

@section('content')
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">User Profile</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">My Profile</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <ul class="nav nav-tabs profile-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="profile-tab-1" data-bs-toggle="tab" href="#profile-1"
                                    role="tab" aria-selected="true">
                                    <i class="ti ti-user me-2"></i>Profile
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab-2" data-bs-toggle="tab" href="#profile-2" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="ti ti-file-text me-2"></i>Biodata
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab-3" data-bs-toggle="tab" href="#profile-3" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <i class="ti ti-lock me-2"></i>Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- TAB 1: PROFILE -->
                            <div class="tab-pane active show" id="profile-1" role="tabpanel"
                                aria-labelledby="profile-tab-1">
                                <div class="row">
                                    <div class="col-lg-4 col-xxl-3">
                                        <div class="card">
                                            <div class="card-body position-relative">
                                                <div class="position-absolute end-0 top-0 p-3">
                                                    <span class="badge bg-success">Active</span>
                                                </div>
                                                <div class="text-center mt-3">
                                                    <div class="chat-avtar d-inline-flex mx-auto">
                                        <img class="rounded-circle img-fluid wid-70"
                                            src="{{ $avatar ?: asset('assets/images/user/avatar-5.jpg') }}"
                                            onerror="this.src='{{ asset('assets/images/user/avatar-5.jpg') }}'"
                                            alt="User image">
                                    </div>
                                                    <h5 class="mb-0 mt-3">{{ $user->name }}</h5>
                                                    <p class="text-muted text-sm">{{ ucfirst($user->role) }}</p>
                                                    <hr class="my-3">

                                                    {{-- Informasi dari Biodata --}}
                                                    @if($biodata)
                                                        <div class="text-start mb-3">
                                                            <p class="text-muted small mb-1"><i
                                                                    class="ti ti-calendar me-1"></i>Umur</p>
                                                            <p class="mb-0 fw-bold">{{ $biodata->umur ?? '-' }} Tahun</p>
                                                        </div>

                                                        <div class="text-start mb-3">
                                                            <p class="text-muted small mb-1"><i
                                                                    class="ti ti-gender-bigender me-1"></i>Jenis Kelamin</p>
                                                            <p class="mb-0 fw-bold">
                                                                {{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : ($biodata->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}
                                                            </p>
                                                        </div>

                                                        <div class="text-start mb-3">
                                                            <p class="text-muted small mb-1"><i
                                                                    class="ti ti-building me-1"></i>Pekerjaan</p>
                                                            <p class="mb-0 fw-bold">{{ $biodata->pekerjaan ?? '-' }}
                                                            </p>
                                                        </div>

                                                        <div class="text-start mb-3">
                                                            <p class="text-muted small mb-1"><i
                                                                    class="ti ti-map-pin me-1"></i>Alamat</p>
                                                            <p class="mb-0 text-sm">{{ $biodata->desa_kelurahan ?? '-' }},
                                                                {{ $biodata->kecamatan ?? '-' }}, {{ $biodata->kabupaten_kota ?? '-' }}
                                                            </p>
                                                        </div>

                                                        <div class="text-start mb-3">
                                                            <p class="text-muted small mb-1"><i
                                                                    class="ti ti-check-circle me-1"></i>Status Verifikasi</p>
                                                            <span
                                                                class="badge bg-{{ $biodata->status_badge }}">{{ $biodata->status_label }}</span>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning text-start">
                                                            <i class="ti ti-alert-circle me-2"></i>
                                                            <small>Biodata belum lengkap. Silakan <a href="{{ route('user.biodata.show') }}">lengkapi biodata</a> Anda.</small>
                                                        </div>
                                                    @endif

                                                    <hr class="my-3">
                                                    <a href="{{ route('user.biodata.show') }}"
                                                        class="btn btn-primary btn-sm w-100">
                                                        <i class="ti ti-pencil me-1"></i>Lihat Biodata
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-xxl-9">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Informasi Akun</h5>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item px-0 pt-0">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p class="mb-1 text-muted">Nama Lengkap</p>
                                                                <p class="mb-0 fw-bold">{{ $user->name }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="mb-1 text-muted">NIK</p>
                                                                <p class="mb-0 fw-bold">{{ $user->nik ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p class="mb-1 text-muted">Email</p>
                                                                <p class="mb-0 fw-bold">{{ $user->email }}</p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="mb-1 text-muted">Role</p>
                                                                <p class="mb-0 fw-bold text-capitalize">{{ $user->role }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                    <h6 class="mb-1">Verifikasi Email</h6>
                                                    <p class="text-muted small mb-0">
                                                    @if($user->is_verified)
                                                    Email sudah terverifikasi pada {{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : $user->updated_at->format('d M Y') }}
                                                 @else
                                                Verifikasi email untuk keamanan maksimal
                                            @endif
                                        </p>
                                </div>
                                         @if(!$user->is_verified)
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#verifyEmailModal">
                                            <i class="ti ti-mail me-1"></i>Verifikasi
                                        </button>
                                        @else
                                            <span class="badge bg-success">✓ Terverifikasi</span>
                                                @endif
                                                </div>
                                            </li>
                                                    @if($biodata)
                                                        <li class="list-group-item px-0">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p class="mb-1 text-muted">No. HP</p>
                                                                    <p class="mb-0 fw-bold">{{ $biodata->no_hp ?? '-' }}</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="mb-1 text-muted">Tempat/Tanggal Lahir</p>
                                                                    <p class="mb-0 fw-bold">
                                                                        {{ $biodata->tempat_lahir ?? '-' }},
                                                                        {{ $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('d M Y') : '-' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item px-0">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p class="mb-1 text-muted">Agama</p>
                                                                    <p class="mb-0 fw-bold">{{ $biodata->agama ?? '-' }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p class="mb-1 text-muted">Status Perkawinan</p>
                                                                    <p class="mb-0 fw-bold">
                                                                        {{ $biodata->status_perkawinan ?? '-' }}</p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: BIODATA -->
                            <div class="tab-pane" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                                @if($biodata)
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">Data Biodata Lengkap</h5>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editBiodataModal">
                                                        <i class="ti ti-edit me-1"></i>Edit
                                                    </button>
                                                    <span class="badge bg-{{ $biodata->status_badge }}">{{ $biodata->status_label }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h6 class="border-bottom pb-2 mb-3">Data Diri</h6>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <p class="text-muted small">NIK</p>
                                                    <p class="fw-bold">{{ $biodata->nik }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Nama Lengkap</p>
                                                    <p class="fw-bold">{{ $biodata->nama_lengkap }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Tempat Lahir</p>
                                                    <p>{{ $biodata->tempat_lahir ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Tanggal Lahir</p>
                                                    <p>{{ $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('d M Y') : '-' }}
                                                        ({{ $biodata->umur ?? '-' }} Tahun)</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Jenis Kelamin</p>
                                                    <p>{{ $biodata->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Agama</p>
                                                    <p>{{ $biodata->agama ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Status Perkawinan</p>
                                                    <p>{{ $biodata->status_perkawinan ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Pekerjaan</p>
                                                    <p>{{ $biodata->pekerjaan ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <h6 class="border-bottom pb-2 mb-3 mt-4">Alamat</h6>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <p class="text-muted small">Alamat Lengkap</p>
                                                    <p>{{ $biodata->alamat_lengkap ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="text-muted small">RT</p>
                                                    <p>{{ $biodata->rt ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <p class="text-muted small">RW</p>
                                                    <p>{{ $biodata->rw ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Desa/Kelurahan</p>
                                                    <p>{{ $biodata->desa_kelurahan ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Kecamatan</p>
                                                    <p>{{ $biodata->kecamatan ?? '-' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="text-muted small">Kabupaten/Kota</p>
                                                    <p>{{ $biodata->kabupaten_kota ?? '-' }}</p>
                                                </div>
                                            </div>

                                            <h6 class="border-bottom pb-2 mb-3 mt-4">Dokumen</h6>
                                            <div class="row">
                                                @if($biodata->foto_ktp)
                                                    <div class="col-md-4">
                                                        <p class="text-muted small">Foto KTP</p>
                                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_ktp) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="ti ti-eye me-1"></i>Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                @if($biodata->foto_kk)
                                                    <div class="col-md-4">
                                                        <p class="text-muted small">Foto KK</p>
                                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_kk) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="ti ti-eye me-1"></i>Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                                @if($biodata->foto_diri)
                                                    <div class="col-md-4">
                                                        <p class="text-muted small">Foto Diri</p>
                                                        <a href="{{ asset('storage/biodata/' . $biodata->foto_diri) }}"
                                                            target="_blank" class="btn btn-sm btn-outline-primary">
                                                            <i class="ti ti-eye me-1"></i>Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit Biodata -->
                                    <div class="modal fade" id="editBiodataModal" tabindex="-1" aria-labelledby="editBiodataModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editBiodataModalLabel">Edit Biodata</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="editBiodataAlert"></div>
                                                    <form id="editBiodataForm">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">NIK</label>
                                                                    <input type="text" class="form-control" name="nik" value="{{ $biodata->nik ?? '' }}" readonly>
                                                                    <small class="text-muted">NIK tidak dapat diubah</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Nama Lengkap</label>
                                                                    <input type="text" class="form-control" name="nama_lengkap" value="{{ $biodata->nama_lengkap ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Tempat Lahir</label>
                                                                    <input type="text" class="form-control" name="tempat_lahir" value="{{ $biodata->tempat_lahir ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Tanggal Lahir</label>
                                                                    <input type="date" class="form-control" name="tanggal_lahir" value="{{ $biodata->tanggal_lahir ? $biodata->tanggal_lahir->format('Y-m-d') : '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Jenis Kelamin</label>
                                                                    <select class="form-control" name="jenis_kelamin" required>
                                                                        <option value="">Pilih Jenis Kelamin</option>
                                                                        <option value="L" {{ ($biodata->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                                        <option value="P" {{ ($biodata->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Agama</label>
                                                                    <select class="form-control" name="agama" required>
                                                                        <option value="">Pilih Agama</option>
                                                                        <option value="Islam" {{ ($biodata->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                        <option value="Kristen" {{ ($biodata->agama ?? '') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                                        <option value="Katolik" {{ ($biodata->agama ?? '') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                                                        <option value="Hindu" {{ ($biodata->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                                        <option value="Buddha" {{ ($biodata->agama ?? '') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                                                        <option value="Konghucu" {{ ($biodata->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Status Perkawinan</label>
                                                                    <select class="form-control" name="status_perkawinan" required>
                                                                        <option value="">Pilih Status</option>
                                                                        <option value="Belum Kawin" {{ ($biodata->status_perkawinan ?? '') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                                                        <option value="Kawin" {{ ($biodata->status_perkawinan ?? '') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                                                        <option value="Cerai Hidup" {{ ($biodata->status_perkawinan ?? '') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                                                        <option value="Cerai Mati" {{ ($biodata->status_perkawinan ?? '') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Pekerjaan</label>
                                                                    <input type="text" class="form-control" name="pekerjaan" value="{{ $biodata->pekerjaan ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">No. HP</label>
                                                                    <input type="text" class="form-control" name="no_hp" value="{{ $biodata->no_hp ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" class="form-control" name="email" value="{{ $biodata->email ?? '' }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <h6 class="mt-4 mb-3">Alamat</h6>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Alamat Lengkap</label>
                                                                    <textarea class="form-control" name="alamat_lengkap" rows="3" required>{{ $biodata->alamat_lengkap ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">RT</label>
                                                                    <input type="text" class="form-control" name="rt" value="{{ $biodata->rt ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">RW</label>
                                                                    <input type="text" class="form-control" name="rw" value="{{ $biodata->rw ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Desa/Kelurahan</label>
                                                                    <input type="text" class="form-control" name="desa_kelurahan" value="{{ $biodata->desa_kelurahan ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Kecamatan</label>
                                                                    <input type="text" class="form-control" name="kecamatan" value="{{ $biodata->kecamatan ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="form-label">Kabupaten/Kota</label>
                                                                    <input type="text" class="form-control" name="kabupaten_kota" value="{{ $biodata->kabupaten_kota ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="button" class="btn btn-primary" id="submitEditBiodataBtn">Simpan Perubahan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="ti ti-alert-circle me-2"></i>
                                        <strong>Biodata Belum Tersedia</strong>
                                        <p class="mb-0 mt-2">Silakan hubungi admin untuk menambahkan biodata Anda.</p>
                                    </div>
                                @endif
                            </div>

                            <!-- TAB 3: CHANGE PASSWORD -->
                            <div class="tab-pane" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Ubah Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="alertContainer"></div>
                                        <form id="changePasswordForm">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Password Lama</label>
                                                        <input type="password" class="form-control" id="currentPassword" name="current_password"
                                                            placeholder="Masukkan password lama" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Password Baru</label>
                                                        <input type="password" class="form-control" id="newPassword" name="new_password"
                                                            placeholder="Masukkan password baru" required>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Konfirmasi Password</label>
                                                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation"
                                                            placeholder="Konfirmasi password baru" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6 class="mb-3">Password harus mengandung:</h6>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-length">Minimal 8 karakter</span>
                                                        </li>
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-lowercase">Huruf kecil (a-z)</span>
                                                        </li>
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-uppercase">Huruf besar (A-Z)</span>
                                                        </li>
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-number">Angka (0-9)</span>
                                                        </li>
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-special">Karakter spesial (!@#$%^&*)</span>
                                                        </li>
                                                        <li class="list-group-item px-0 py-2">
                                                            <i class="ti ti-minus me-2"></i>
                                                            <span id="check-match">Password cocok</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-end btn-page">
                                        <button type="button" class="btn btn-outline-secondary" id="resetBtn">Batal</button>
                                        <button type="button" class="btn btn-primary" id="submitBtn">Update Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>

    <!-- Modal Verifikasi Email -->
    <div class="modal fade" id="verifyEmailModal" tabindex="-1" aria-labelledby="verifyEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyEmailModalLabel">Verifikasi Email</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Hidden CSRF Token for JavaScript access -->
                    <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                    
                    <div id="otpInputSection" class="d-none">
                        <p class="text-muted small mb-3">Kode OTP telah dikirim ke email Anda. Silakan masukkan kode tersebut:</p>
                        <div class="form-group mb-3">
                            <label class="form-label">Kode OTP</label>
                            <input type="text" class="form-control form-control-lg text-center" id="otpCode" 
                                placeholder="Masukkan 6 digit kode" maxlength="6" inputmode="numeric">
                            <small class="text-muted">Kode OTP berlaku selama 5 menit</small>
                        </div>
                        <div class="form-group">
                            <p class="text-muted small mb-0">Belum menerima kode? 
                                <button type="button" class="btn btn-link btn-sm p-0" id="resendOtpBtn">Kirim Ulang</button>
                                <span id="resendCountdown" class="text-muted small d-none">
                                    (Coba dalam <strong id="countdownTimer">60</strong>s)
                                </span>
                            </p>
                        </div>
                    </div>
                    <div id="loadingSection" class="text-center d-none">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted small">Mengirim kode OTP...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="verifyOtpBtn" style="display: none;">Verifikasi</button>
                    <button type="button" class="btn btn-primary" id="sendOtpBtnModal">Kirim OTP</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Password -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="changePasswordAlert"></div>
                    <form id="changePasswordModalForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-label">Password Lama</label>
                            <input type="password" class="form-control" name="current_password" placeholder="Masukkan password lama" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" placeholder="Masukkan password baru (min. 8 karakter)" required>
                            <small class="text-muted">Harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial</small>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="new_password_confirmation" placeholder="Konfirmasi password baru" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="submitChangePasswordBtn">Ubah Password</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token dari berbagai sumber dengan fallback
        const getCsrfToken = () => {
            // Prioritas 1: Hidden input dalam modal
            const modalToken = document.getElementById('csrfToken')?.value;
            if (modalToken) {
                console.log('CSRF token dari modal input');
                return modalToken;
            }
            
            // Prioritas 2: Meta tag di head
            const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (metaToken) {
                console.log('CSRF token dari meta tag');
                return metaToken;
            }
            
            // Prioritas 3: Input field di form
            const formToken = document.querySelector('input[name="_token"]')?.value;
            if (formToken) {
                console.log('CSRF token dari form input');
                return formToken;
            }
            
            // Fallback: Blade directive (ini akan di-evaluate di server)
            console.log('CSRF token dari Blade directive');
            return '{{ csrf_token() }}';
        };

        function startResendCountdown() {
            const resendOtpBtn = document.getElementById('resendOtpBtn');
            const resendCountdown = document.getElementById('resendCountdown');
            const countdownTimer = document.getElementById('countdownTimer');
            let seconds = 60;

            // Disable button dan tampilkan countdown
            resendOtpBtn.disabled = true;
            resendOtpBtn.style.opacity = '0.5';
            resendOtpBtn.style.cursor = 'not-allowed';
            resendCountdown.classList.remove('d-none');

            const countdownInterval = setInterval(function() {
                seconds--;
                countdownTimer.textContent = seconds;

                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    // Enable button kembali
                    resendOtpBtn.disabled = false;
                    resendOtpBtn.style.opacity = '1';
                    resendOtpBtn.style.cursor = 'pointer';
                    resendCountdown.classList.add('d-none');
                    console.log('Resend OTP button enabled');
                }
            }, 1000);
        }

        function sendOtp() {
            const btn = document.getElementById('sendOtpBtnModal');
            const verifyBtn = document.getElementById('verifyOtpBtn');
            const loading = document.getElementById('loadingSection');
            const otpInput = document.getElementById('otpInputSection');

            btn.style.display = 'none';
            verifyBtn.style.display = 'none';
            loading.classList.remove('d-none');

            const csrfToken = getCsrfToken();
            console.log('Using CSRF token:', csrfToken);

            const requestUrl = '{{ route("send.otp.auth") }}';
            console.log('Sending request to:', requestUrl);

            fetch(requestUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers.get('Content-Type'));
                
                if (!response.ok) {
                    console.error('Response not OK:', response.statusText);
                    // Handle 429 error specifically
                    if (response.status === 429) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Terlalu banyak permintaan. Silakan tunggu beberapa saat.');
                        });
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                loading.classList.add('d-none');
                
                if (data.success) {
                    otpInput.classList.remove('d-none');
                    verifyBtn.style.display = 'block';
                    document.getElementById('otpCode').value = '';
                    document.getElementById('otpCode').focus();
                    showAlert('success', data.message || 'Kode OTP telah dikirim ke email Anda');
                    
                    // Start countdown timer untuk resend button
                    startResendCountdown();
                } else {
                    showAlert('error', data.message || 'Gagal mengirim OTP');
                    btn.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                console.error('Error stack:', error.stack);
                loading.classList.add('d-none');
                btn.style.display = 'block';
                
                // Handle specific error messages
                let errorMessage = error.message;
                if (error.message.includes('429') || error.message.includes('Terlalu banyak')) {
                    errorMessage = 'Tunggu beberapa saat sebelum mencoba lagi';
                    // Start longer countdown for 429 errors
                    startResendCountdown();
                }
                
                showAlert('error', errorMessage);
            });
        }

        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            const modalBody = document.querySelector('#verifyEmailModal .modal-body');
            const existingAlert = modalBody.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            modalBody.insertBefore(alertDiv, modalBody.firstChild);
        }

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - initializing OTP form');
            
            const verifyOtpBtn = document.getElementById('verifyOtpBtn');
            const resendOtpBtn = document.getElementById('resendOtpBtn');
            const sendOtpBtnModal = document.getElementById('sendOtpBtnModal');

            if (sendOtpBtnModal) {
                sendOtpBtnModal.addEventListener('click', sendOtp);
                console.log('Send OTP button listener attached');
            }

            if (resendOtpBtn) {
                resendOtpBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Resend OTP clicked');
                    sendOtp();
                });
                console.log('Resend OTP button listener attached');
            }

            if (verifyOtpBtn) {
                verifyOtpBtn.addEventListener('click', function() {
                    const otp = document.getElementById('otpCode').value;
                    
                    if (!otp || otp.length !== 6) {
                        showAlert('error', 'Silakan masukkan kode OTP 6 digit');
                        return;
                    }

                    const csrfToken = getCsrfToken();
                    console.log('Verifying OTP with token:', csrfToken);

                    fetch('{{ route("verify.otp.auth") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ otp: otp })
                    })
                    .then(response => {
                        console.log('Verify response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('Verify response data:', data);
                        if (data.success) {
                            showAlert('success', data.message || 'Email berhasil diverifikasi!');
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            showAlert('error', data.message || 'Kode OTP tidak valid');
                        }
                    })
                    .catch(error => {
                        console.error('Verify error:', error);
                        showAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
                    });
                });
                console.log('Verify OTP button listener attached');
            }
        });

        // ==========================================
        // CHANGE PASSWORD FUNCTIONALITY
        // ==========================================
        
        const changePasswordForm = document.getElementById('changePasswordForm');
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        const submitBtn = document.getElementById('submitBtn');
        const resetBtn = document.getElementById('resetBtn');
        const submitChangePasswordBtn = document.getElementById('submitChangePasswordBtn');

        // Password validation function
        function validatePassword(password) {
            return {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*]/.test(password),
            };
        }

        // Update password requirements display
        function updatePasswordChecklist(password) {
            const validation = validatePassword(password);
            
            document.getElementById('check-length').textContent = validation.length ? '✓ Minimal 8 karakter' : 'Minimal 8 karakter';
            document.getElementById('check-length').className = validation.length ? 'text-success' : '';
            
            document.getElementById('check-lowercase').textContent = validation.lowercase ? '✓ Huruf kecil (a-z)' : 'Huruf kecil (a-z)';
            document.getElementById('check-lowercase').className = validation.lowercase ? 'text-success' : '';
            
            document.getElementById('check-uppercase').textContent = validation.uppercase ? '✓ Huruf besar (A-Z)' : 'Huruf besar (A-Z)';
            document.getElementById('check-uppercase').className = validation.uppercase ? 'text-success' : '';
            
            document.getElementById('check-number').textContent = validation.number ? '✓ Angka (0-9)' : 'Angka (0-9)';
            document.getElementById('check-number').className = validation.number ? 'text-success' : '';
            
            document.getElementById('check-special').textContent = validation.special ? '✓ Karakter spesial (!@#$%^&*)' : 'Karakter spesial (!@#$%^&*)';
            document.getElementById('check-special').className = validation.special ? 'text-success' : '';
            
            const passwordsMatch = confirmPasswordInput.value && password === confirmPasswordInput.value;
            document.getElementById('check-match').textContent = passwordsMatch ? '✓ Password cocok' : 'Password cocok';
            document.getElementById('check-match').className = passwordsMatch ? 'text-success' : '';
            
            return Object.values(validation).every(v => v) && passwordsMatch;
        }

        // Real-time password validation
        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', function() {
                updatePasswordChecklist(this.value);
            });
        }

        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                updatePasswordChecklist(newPasswordInput.value);
            });
        }

        // Submit change password form (Tab version)
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!currentPassword) {
                    showPasswordAlert('error', 'Password lama harus diisi');
                    return;
                }

                const validation = validatePassword(newPassword);
                if (!Object.values(validation).every(v => v)) {
                    showPasswordAlert('error', 'Password tidak memenuhi kriteria keamanan');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showPasswordAlert('error', 'Konfirmasi password tidak cocok');
                    return;
                }

                submitChangePasswordBtn.click();
            });
        }

        // Reset form
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                if (changePasswordForm) {
                    changePasswordForm.reset();
                    document.querySelectorAll('#check-length, #check-lowercase, #check-uppercase, #check-number, #check-special, #check-match').forEach(el => {
                        el.className = '';
                    });
                }
            });
        }

        // Submit change password from modal
        if (submitChangePasswordBtn) {
            submitChangePasswordBtn.addEventListener('click', function() {
                const form = document.getElementById('changePasswordModalForm');
                const currentPassword = form.querySelector('input[name="current_password"]').value;
                const newPassword = form.querySelector('input[name="new_password"]').value;
                const confirmPassword = form.querySelector('input[name="new_password_confirmation"]').value;

                if (!currentPassword) {
                    showPasswordAlert('error', 'Password lama harus diisi', 'changePasswordAlert');
                    return;
                }

                const validation = validatePassword(newPassword);
                if (!Object.values(validation).every(v => v)) {
                    showPasswordAlert('error', 'Password baru tidak memenuhi kriteria keamanan:\n- Minimal 8 karakter\n- Huruf besar, huruf kecil, angka, dan karakter spesial', 'changePasswordAlert');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showPasswordAlert('error', 'Konfirmasi password tidak cocok', 'changePasswordAlert');
                    return;
                }

                // Submit to server
                const csrfToken = getCsrfToken();
                submitChangePasswordBtn.disabled = true;
                submitChangePasswordBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Proses...';

                fetch('{{ route("profile.update.password") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        new_password: newPassword,
                        new_password_confirmation: confirmPassword
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showPasswordAlert('success', data.message, 'changePasswordAlert');
                        form.reset();
                        setTimeout(() => {
                            // Logout dan redirect ke login
                            window.location.href = '{{ route("login") }}';
                        }, 2000);
                    } else {
                        showPasswordAlert('error', data.message || 'Gagal mengubah password', 'changePasswordAlert');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showPasswordAlert('error', 'Terjadi kesalahan. Silakan coba lagi.', 'changePasswordAlert');
                })
                .finally(() => {
                    submitChangePasswordBtn.disabled = false;
                    submitChangePasswordBtn.innerHTML = 'Ubah Password';
                });
            });
        }

        // Show password alert
        function showPasswordAlert(type, message, containerId = 'alertContainer') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            const container = document.getElementById(containerId);
            const existingAlert = container.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            container.insertBefore(alertDiv, container.firstChild);
        }

        // EDIT BIODATA FUNCTIONALITY
        // ==========================================
        
        const editBiodataForm = document.getElementById('editBiodataForm');
        const submitEditBiodataBtn = document.getElementById('submitEditBiodataBtn');

        // Submit edit biodata form
        if (submitEditBiodataBtn) {
            submitEditBiodataBtn.addEventListener('click', function() {
                const formData = new FormData(editBiodataForm);
                const biodataData = Object.fromEntries(formData.entries());

                // Show loading state
                submitEditBiodataBtn.disabled = true;
                submitEditBiodataBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';

                fetch('{{ route("profile.update.biodata") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(biodataData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showEditBiodataAlert('success', data.message);
                        // Close modal after success
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('editBiodataModal'));
                            modal.hide();
                            // Reload page to show updated data
                            window.location.reload();
                        }, 1500);
                    } else {
                        let errorMessage = data.message || 'Gagal memperbarui biodata';
                        if (data.errors) {
                            errorMessage += '<br><small>' + Object.values(data.errors).flat().join('<br>') + '</small>';
                        }
                        showEditBiodataAlert('error', errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showEditBiodataAlert('error', 'Terjadi kesalahan. Silakan coba lagi.');
                })
                .finally(() => {
                    submitEditBiodataBtn.disabled = false;
                    submitEditBiodataBtn.innerHTML = 'Simpan Perubahan';
                });
            });
        }

        // Show edit biodata alert
        function showEditBiodataAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            const container = document.getElementById('editBiodataAlert');
            const existingAlert = container.querySelector('.alert');
            if (existingAlert) {
                existingAlert.remove();
            }
            container.insertBefore(alertDiv, container.firstChild);
        }
    </script>
@endsection
@extends('layouts.dashboard')
@section('title', 'Edit Biodata')
@section('content')
<div class="pc-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.biodata.index') }}">Kelola Data Penduduk</a></li>
                        <li class="breadcrumb-item">Edit</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Biodata</h5>
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

                    <form action="{{ route('admin.biodata.update', $biodata->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')


                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control" value="{{ $biodata->nik }}" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $biodata->nama_lengkap) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $biodata->tempat_lahir) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($biodata->tanggal_lahir)->format('Y-m-d')) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="">- Pilih -</option>
                                        <option value="Laki-laki" {{ $biodata->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ $biodata->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Agama</label>
                                    <input type="text" name="agama" class="form-control" value="{{ old('agama', $biodata->agama) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status Perkawinan</label>
                                    <input type="text" name="status_perkawinan" class="form-control" value="{{ old('status_perkawinan', $biodata->status_perkawinan) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $biodata->pekerjaan) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kewarganegaraan</label>
                                    <input type="text" name="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $biodata->kewarganegaraan) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control">{{ old('alamat_lengkap', $biodata->alamat_lengkap) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">RT</label>
                                        <input type="text" name="rt" class="form-control" value="{{ old('rt', $biodata->rt) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">RW</label>
                                        <input type="text" name="rw" class="form-control" value="{{ old('rw', $biodata->rw) }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Kode Pos</label>
                                        <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos', $biodata->kode_pos) }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Desa / Kelurahan</label>
                                    <input type="text" name="desa_kelurahan" class="form-control" value="{{ old('desa_kelurahan', $biodata->desa_kelurahan) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan', $biodata->kecamatan) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kabupaten / Kota</label>
                                    <input type="text" name="kabupaten_kota" class="form-control" value="{{ old('kabupaten_kota', $biodata->kabupaten_kota) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="{{ old('provinsi', $biodata->provinsi) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No. HP</label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $biodata->no_hp) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $biodata->email) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah', $biodata->nama_ayah) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" name="pekerjaan_ayah" class="form-control" value="{{ old('pekerjaan_ayah', $biodata->pekerjaan_ayah) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu', $biodata->nama_ibu) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" name="pekerjaan_ibu" class="form-control" value="{{ old('pekerjaan_ibu', $biodata->pekerjaan_ibu) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" name="pendidikan_terakhir" class="form-control" value="{{ old('pendidikan_terakhir', $biodata->pendidikan_terakhir) }}">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h6>Dokumen (KTP / KK / Foto Diri)</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto KTP</label>
                                    @if($biodata->foto_ktp)
                                        <div class="mb-2"><a target="_blank" href="{{ asset('storage/biodata/'.$biodata->foto_ktp) }}">Lihat KTP saat ini</a></div>
                                    @endif
                                    <input type="file" name="foto_ktp" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto KK</label>
                                    @if($biodata->foto_kk)
                                        <div class="mb-2"><a target="_blank" href="{{ asset('storage/biodata/'.$biodata->foto_kk) }}">Lihat KK saat ini</a></div>
                                    @endif
                                    <input type="file" name="foto_kk" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Foto Diri</label>
                                    @if($biodata->foto_diri)
                                        <div class="mb-2"><a target="_blank" href="{{ asset('storage/biodata/'.$biodata->foto_diri) }}">Lihat Foto Diri saat ini</a></div>
                                    @endif
                                    <input type="file" name="foto_diri" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Verifikasi</label>
                            <select name="status_verifikasi" class="form-control">
                                <option value="belum_verifikasi" {{ $biodata->status_verifikasi == 'belum_verifikasi' ? 'selected' : '' }}>Belum Verifikasi</option>
                                <option value="sedang_diverifikasi" {{ $biodata->status_verifikasi == 'sedang_diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
                                <option value="terverifikasi" {{ $biodata->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="ditolak" {{ $biodata->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan Admin</label>
                            <textarea name="catatan_admin" class="form-control">{{ old('catatan_admin', $biodata->catatan_admin) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.biodata.show', $biodata->id) }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>

                    <hr>
                    <form action="{{ route('admin.biodata.destroy', $biodata->id) }}" method="POST" onsubmit="return confirm('Hapus biodata ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Hapus Biodata</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

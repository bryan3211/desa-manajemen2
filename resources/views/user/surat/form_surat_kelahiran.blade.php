@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Keterangan Kelahiran')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Keterangan Kelahiran</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="surat_kelahiran">

                <h6>Data Bayi</h6>
                <div class="mb-3">
                    <label>Nama Bayi</label>
                    <input type="text" name="nama_bayi" class="form-control" value="{{ old('nama_bayi') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">- Pilih -</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <h6>Data Orang Tua</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>NIK Ibu</label>
                            <input type="text" name="nik_ibu" class="form-control" value="{{ old('nik_ibu') }}" maxlength="16" placeholder="16 digit NIK (opsional)">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>NIK Ayah</label>
                            <input type="text" name="nik_ayah" class="form-control" value="{{ old('nik_ayah') }}" maxlength="16" placeholder="16 digit NIK (opsional)">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - scan dokumen)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>
@endsection

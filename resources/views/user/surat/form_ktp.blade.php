@extends('layouts.dashboard')
@section('title','Pengajuan Surat - KTP')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Permohonan KTP</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="ktp">

                <div class="mb-3">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $biodata->nik ?? '') }}" readonly required>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? '') }}" readonly required>
                </div>

                <div class="mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - scan KTP atau dokumen pendukung)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>
@endsection

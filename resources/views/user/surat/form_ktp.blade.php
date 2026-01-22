@extends('layouts.dashboard')
@section('title','Pengajuan Surat - KTP')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Permohonan KTP</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($is_edit) && $is_edit ? route('user.surat.update', $surat->id) : route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($is_edit) && $is_edit)
                    @method('PUT')
                @endif
                <input type="hidden" name="jenis_surat" value="ktp">

                <div class="mb-3">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['nik'] ?? '') : old('nik', $biodata->nik ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['nama_lengkap'] ?? '') : old('nama_lengkap', $biodata->nama_lengkap ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['tempat_lahir'] ?? '') : old('tempat_lahir') }}">
                </div>

                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['tanggal_lahir'] ?? '') : old('tanggal_lahir') }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ isset($is_edit) && $is_edit ? ($surat->data['alamat'] ?? '') : old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - scan KTP atau dokumen pendukung)</label>
                    <input type="file" name="attachment" class="form-control">
                    @if(isset($is_edit) && $is_edit && $surat->attachment)
                        <small class="text-muted">File saat ini: {{ $surat->attachment }}</small>
                    @endif
                </div>

                <button class="btn btn-primary">{{ isset($is_edit) && $is_edit ? 'Update Pengajuan' : 'Kirim Pengajuan' }}</button>
                <a href="{{ route('user.surat.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection

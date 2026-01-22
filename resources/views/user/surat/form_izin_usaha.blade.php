@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Izin Usaha')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Izin Usaha</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($is_edit) && $is_edit ? route('user.surat.update', $surat->id) : route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($is_edit) && $is_edit)
                    @method('PUT')
                @endif
                <input type="hidden" name="jenis_surat" value="izin_usaha">

                <div class="mb-3">
                    <label>Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['nama_usaha'] ?? '') : old('nama_usaha') }}" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Usaha</label>
                    <input type="text" name="jenis_usaha" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['jenis_usaha'] ?? '') : old('jenis_usaha') }}" required>
                </div>

                <div class="mb-3">
                    <label>Alamat Usaha</label>
                    <textarea name="alamat_usaha" class="form-control" required>{{ isset($is_edit) && $is_edit ? ($surat->data['alamat_usaha'] ?? '') : old('alamat_usaha') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Modal Usaha</label>
                    <input type="text" name="modal_usaha" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['modal_usaha'] ?? '') : old('modal_usaha') }}">
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ isset($is_edit) && $is_edit ? ($surat->data['keterangan'] ?? '') : old('keterangan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - dokumen pendukung)</label>
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

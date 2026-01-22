@extends('layouts.dashboard')
@section('title','Pengajuan Surat - SKTM')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan SKTM</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ isset($is_edit) && $is_edit ? route('user.surat.update', $surat->id) : route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($is_edit) && $is_edit)
                    @method('PUT')
                @endif
                <input type="hidden" name="jenis_surat" value="sktm">

                <div class="mb-3">
                    <label>Tujuan</label>
                    <input type="text" name="tujuan" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['tujuan'] ?? '') : old('tujuan') }}" required>
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ isset($is_edit) && $is_edit ? ($surat->data['keterangan'] ?? '') : old('keterangan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Jumlah Anggota Keluarga</label>
                    <input type="number" name="jumlah_anggota_keluarga" class="form-control" value="{{ isset($is_edit) && $is_edit ? ($surat->data['jumlah_anggota_keluarga'] ?? '') : old('jumlah_anggota_keluarga') }}">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control">{{ isset($is_edit) && $is_edit ? ($surat->data['alamat'] ?? '') : old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - bukti pendukung)</label>
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

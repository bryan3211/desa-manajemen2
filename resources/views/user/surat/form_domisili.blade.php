@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Keterangan Domisili')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Keterangan Domisili</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ $is_edit ? route('user.surat.update', $surat->id) : route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                @if($is_edit) @method('PUT') @endif
                <input type="hidden" name="jenis_surat" value="domisili">

                <div class="mb-3">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" required>{{ $is_edit ? ($surat->data['alamat'] ?? '') : old('alamat') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Tujuan Surat</label>
                    <input type="text" name="tujuan" class="form-control" value="{{ $is_edit ? ($surat->data['tujuan'] ?? '') : old('tujuan') }}">
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control">{{ $is_edit ? ($surat->data['keterangan'] ?? '') : old('keterangan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional)</label>
                    <input type="file" name="attachment" class="form-control">
                    @if($is_edit && $surat->attachment)
                        <small class="text-muted">File saat ini: {{ basename($surat->attachment) }}</small>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('user.surat.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">{{ $is_edit ? 'Update Pengajuan' : 'Kirim Pengajuan' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

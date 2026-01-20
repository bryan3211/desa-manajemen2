@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Rekomendasi')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Rekomendasi</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="surat_rekomendasi">

                <div class="mb-3">
                    <label>Tujuan Surat</label>
                    <input type="text" name="tujuan" class="form-control" value="{{ old('tujuan') }}" required>
                </div>

                <div class="mb-3">
                    <label>Keperluan</label>
                    <textarea name="keperluan" class="form-control" required>{{ old('keperluan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>
@endsection

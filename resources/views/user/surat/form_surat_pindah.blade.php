@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Pindah/Mutasi')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Pindah/Mutasi</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="surat_pindah">

                <div class="mb-3">
                    <label>Alamat Asal</label>
                    <textarea name="alamat_asal" class="form-control" required>{{ old('alamat_asal') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Desa Tujuan</label>
                            <input type="text" name="desa_tujuan" class="form-control" value="{{ old('desa_tujuan') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Kecamatan Tujuan</label>
                            <input type="text" name="kecamatan_tujuan" class="form-control" value="{{ old('kecamatan_tujuan') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Alasan Pindah</label>
                    <textarea name="alasan_pindah" class="form-control">{{ old('alasan_pindah') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Jumlah Anggota Keluarga</label>
                    <input type="number" name="jumlah_anggota_keluarga" class="form-control" value="{{ old('jumlah_anggota_keluarga') }}">
                </div>

                <div class="mb-3">
                    <label>Lampiran (opsional - dokumen pendukung)</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <button class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>
@endsection

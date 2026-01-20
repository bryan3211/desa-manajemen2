@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Keterangan Kematian')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Keterangan Kematian</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="surat_kematian">

                <div class="mb-3">
                    <label>Nama Almarhum/Almarhumah</label>
                    <input type="text" name="nama_almarhum" class="form-control" value="{{ old('nama_almarhum') }}" required>
                </div>

                <div class="mb-3">
                    <label>NIK (Opsional)</label>
                    <input type="text" name="nik_almarhum" class="form-control" value="{{ old('nik_almarhum') }}" maxlength="16" placeholder="16 digit NIK (opsional)">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tanggal Meninggal</label>
                            <input type="date" name="tanggal_meninggal" class="form-control" value="{{ old('tanggal_meninggal') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Usia</label>
                            <input type="number" name="usia" class="form-control" value="{{ old('usia') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Tempat Meninggal</label>
                    <input type="text" name="tempat_meninggal" class="form-control" value="{{ old('tempat_meninggal') }}" required>
                </div>

                <div class="mb-3">
                    <label>Penyebab Kematian</label>
                    <textarea name="penyebab_kematian" class="form-control">{{ old('penyebab_kematian') }}</textarea>
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

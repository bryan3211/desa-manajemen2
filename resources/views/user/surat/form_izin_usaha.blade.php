@extends('layouts.dashboard')
@section('title','Pengajuan Surat - Surat Izin Usaha')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header"><h5>Pengajuan Surat Izin Usaha</h5></div>
        <div class="card-body">
            <form method="POST" action="{{ route('user.surat.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis_surat" value="izin_usaha">

                <div class="mb-3">
                    <label>Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-control" value="{{ old('nama_usaha') }}" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Usaha</label>
                    <input type="text" name="jenis_usaha" class="form-control" value="{{ old('jenis_usaha') }}" required>
                </div>

                <div class="mb-3">
                    <label>Alamat Usaha</label>
                    <textarea name="alamat_usaha" class="form-control" required>{{ old('alamat_usaha') }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Modal Usaha</label>
                    <input type="text" name="modal_usaha" class="form-control" value="{{ old('modal_usaha') }}">
                </div>

                <div class="mb-3">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ old('keterangan') }}</textarea>
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

@extends('layouts.dashboard')
@section('title','Edit Pengajuan Surat')
@section('content')
<div class="pc-content">
    <div class="card">
        <div class="card-header">
            <h5>Edit Pengajuan {{ strtoupper($surat->jenis_surat) }}</h5>
            <small class="text-muted">ID Pengajuan: {{ $surat->id }}</small>
        </div>
        <div class="card-body">
            @include('user.surat.form_' . $type, ['surat' => $surat, 'is_edit' => true])
        </div>
    </div>
</div>
@endsection
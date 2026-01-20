@extends('layouts.dashboard')
@section('title','Detail Pengajuan Surat #'.$surat->id)
@section('content')
    <div class="pc-content">
        <!-- Breadcrumb -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.surat.index') }}">Kelola Pengajuan Surat</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Pengajuan Surat #{{ $surat->id }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="ti ti-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1">Pengajuan oleh: {{ $surat->user?->email ?? '-' }}</h5>
                            <p class="text-muted mb-0">Dikirim: {{ $surat->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                        <span class="badge bg-{{ $surat->status_verifikasi == 'terverifikasi' ? 'light-success' : ($surat->status_verifikasi == 'sedang_diverifikasi' ? 'light-info' : ($surat->status_verifikasi == 'ditolak' ? 'light-danger' : 'light-warning')) }} px-3 py-2">
                            {{ ucfirst(str_replace('_',' ',$surat->status_verifikasi)) }}
                        </span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Rincian Pengajuan</h5></div>
                    <div class="card-body">
                        <h6 class="border-bottom pb-2 mb-3 text-primary"><i class="ti ti-file-text me-2"></i>Data Pengajuan</h6>

                        @php $data = (array) $surat->data; @endphp
                        <div class="row mb-3">
                            @forelse($data as $key => $value)
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small d-block">{{ ucwords(str_replace('_',' ',$key)) }}</label>
                                    @if(is_array($value))
                                        <pre class="mb-0">{{ json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
                                    @else
                                        <p class="mb-0">{{ $value !== null && $value !== '' ? $value : '-' }}</p>
                                    @endif
                                </div>
                            @empty
                                <div class="col-12 text-muted">Tidak ada data pengajuan.</div>
                            @endforelse
                        </div>

                        @if($surat->attachment)
                            <h6 class="border-bottom pb-2 mb-3 mt-3 text-primary"><i class="ti ti-file-upload me-2"></i>Lampiran</h6>
                            <div class="mb-3">
                                <a href="{{ asset('storage/surat/'.$surat->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-eye me-1"></i>Lihat Lampiran
                                </a>
                            </div>
                        @endif

                        @if($surat->verified_by && $surat->verified_at)
                            <hr class="my-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="text-muted small">Diverifikasi oleh</label>
                                    <p class="mb-0">{{ $surat->verifier?->name ?? 'Admin' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small">Tanggal Verifikasi</label>
                                    <p class="mb-0">{{ $surat->verified_at->format('d F Y H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0">Form Verifikasi</h5></div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.surat.verify', $surat->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Status Verifikasi <span class="text-danger">*</span></label>
                                <select class="form-control" name="status_verifikasi" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="sedang_diverifikasi" {{ $surat->status_verifikasi == 'sedang_diverifikasi' ? 'selected' : '' }}>Sedang Diverifikasi</option>
                                    <option value="terverifikasi" {{ $surat->status_verifikasi == 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="ditolak" {{ $surat->status_verifikasi == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan Admin</label>
                                <textarea class="form-control" name="catatan_admin" rows="4" placeholder="Berikan catatan jika diperlukan...">{{ old('catatan_admin', $surat->catatan_admin) }}</textarea>
                                <small class="text-muted">Catatan akan dilihat oleh user</small>
                            </div>

                            <div class="alert alert-info">
                                <i class="ti ti-info-circle me-2"></i>
                                <small>Pastikan data sudah benar sebelum memverifikasi.</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i class="ti ti-check me-2"></i>Update Status</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><h5 class="mb-0">Quick Actions</h5></div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.surat.index') }}" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-2"></i>Kembali ke Daftar</a>
                            <form action="{{ route('admin.surat.destroy', $surat->id) }}" method="POST" onsubmit="return confirm('Hapus pengajuan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"><i class="ti ti-trash me-2"></i>Hapus Pengajuan</button>
                            </form>
                            <a href="{{ route('admin.surat.print', $surat->id) }}" target="_blank" class="btn btn-outline-info"><i class="ti ti-printer me-2"></i>Cetak Data</a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header"><h5 class="mb-0">Surat & Preview</h5></div>
                    <div class="card-body">
                        <div class="mb-2">
                            <label class="form-label small">Preview Keterangan</label>
                            <div class="border p-2" style="height:150px; overflow:auto; white-space:pre-wrap;">{!! nl2br(e($rendered_body ?? ($surat->data['keterangan'] ?? ''))) !!}</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editSuratModal"><i class="ti ti-edit me-2"></i>Edit Surat</button>

                            <form id="previewForm" action="{{ route('admin.surat.preview', $surat->id) }}" method="POST" target="_blank">
                                @csrf
                                <input type="hidden" name="edited_body" id="preview_edited_body_input">
                                <button type="submit" class="btn btn-outline-info"><i class="ti ti-eye me-2"></i>Preview Print (Open)</button>
                            </form>

                            <form id="saveForm" action="{{ route('admin.surat.save_body', $surat->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="edited_body" id="save_edited_body_input">
                                <button type="submit" class="btn btn-outline-success"><i class="ti ti-save me-2"></i>Simpan Keterangan</button>
                            </form>


                        </div>
                    </div>
                </div>

                <!-- Edit modal -->
                <div class="modal fade" id="editSuratModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Keterangan Surat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea id="edited_body_textarea" class="form-control" rows="12">{{ old('edited_body', $rendered_body ?? ($surat->data['keterangan'] ?? '')) }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-outline-info" id="btnPreviewOpen">Preview (Open)</button>
                                <button type="button" class="btn btn-outline-success" id="btnSaveBody">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const textarea = document.getElementById('edited_body_textarea');
        const previewInput = document.getElementById('preview_edited_body_input');
        const saveInput = document.getElementById('save_edited_body_input');
        const btnPreview = document.getElementById('btnPreviewOpen');
        const btnSave = document.getElementById('btnSaveBody');

        if (btnPreview) {
            btnPreview.addEventListener('click', function(){
                previewInput.value = textarea.value;
                // submit preview form which opens in new tab
                document.getElementById('previewForm').submit();
            });
        }

        if (btnSave) {
            btnSave.addEventListener('click', function(){
                saveInput.value = textarea.value;
                // submit save form
                document.getElementById('saveForm').submit();
            });
        }

        // When modal opens, ensure textarea is focused
        var editModal = document.getElementById('editSuratModal');
        if (editModal) {
            editModal.addEventListener('shown.bs.modal', function () {
                textarea.focus();
            });
        }
    });
</script>
@endpush
@endsection

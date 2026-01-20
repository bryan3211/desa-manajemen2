@extends('layouts.dashboard')

@section('title', 'Agenda Desa')

@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #fef5e7 0%, #fef9f3 100%);">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="ti ti-calendar-event me-2" style="font-size: 1.5rem; color: #f59e0b;"></i>
                    <h5 class="mb-0 fw-bold">Agenda Kegiatan Desa</h5>
                </div>
                <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary btn-sm">
                    <i class="ti ti-plus me-2"></i>Tambah Agenda
                </a>
            </div>
            <p class="text-muted small mt-2 mb-0">Kelola agenda kegiatan desa dan publikasikan ke masyarakat</p>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ti ti-alert-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Search -->
            <div class="mb-4">
                <form method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari agenda..." 
                        value="{{ $search ?? '' }}" style="max-width: 300px;">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="ti ti-search me-1"></i>Cari
                    </button>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($agendas as $agenda)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($agenda->image)
                                            <img src="{{ asset('storage/' . $agenda->image) }}" 
                                                alt="{{ $agenda->title }}" 
                                                class="rounded" width="40" height="40" style="object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded" width="40" height="40" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="ti ti-calendar-event text-white"></i>
                                            </div>
                                        @endif
                                        <span class="fw-bold">{{ \Str::limit($agenda->title, 30) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $agenda->date_start->format('d M Y H:i') }}
                                        @if ($agenda->date_end)
                                            <br>s/d {{ $agenda->date_end->format('d M Y H:i') }}
                                        @endif
                                    </small>
                                </td>
                                <td>{{ \Str::limit($agenda->location, 20) }}</td>
                                <td>
                                    <span class="badge bg-{{ $agenda->status_badge }}">
                                        {{ $agenda->status_label }}
                                    </span>
                                </td>
                                <td>
                                    @if ($agenda->is_published)
                                        <span class="badge bg-success">
                                            <i class="ti ti-eye me-1"></i>Dipublikasikan
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="ti ti-eye-off me-1"></i>Draft
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.agenda.show', $agenda) }}" 
                                            class="btn btn-outline-info btn-sm" title="Lihat">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.agenda.edit', $agenda) }}" 
                                            class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.agenda.togglePublish', $agenda) }}" 
                                            style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $agenda->is_published ? 'danger' : 'success' }} btn-sm" 
                                                title="{{ $agenda->is_published ? 'Sembunyikan' : 'Publikasikan' }}">
                                                <i class="ti {{ $agenda->is_published ? 'ti-eye-off' : 'ti-eye' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.agenda.destroy', $agenda) }}" 
                                            style="display: inline;" onsubmit="return confirm('Yakin hapus agenda ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="ti ti-inbox" style="font-size: 2rem; color: #d1d5db;"></i>
                                    <p class="text-muted mt-2">Belum ada agenda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $agendas->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

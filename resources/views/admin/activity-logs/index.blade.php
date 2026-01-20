@extends('layouts.dashboard')

@section('title', 'Log Aktivitas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Log Aktivitas Sistem</h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="exportLogs()">
                        <i class="ti ti-download"></i> Export
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="clearOldLogs()">
                        <i class="ti ti-trash"></i> Hapus Log Lama
                    </button>
                </div>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" id="search" placeholder="Cari aktivitas..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" id="action_filter">
                            <option value="">Semua Aksi</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select form-select-sm" id="user_filter">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm" id="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" class="form-control form-control-sm" id="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary btn-sm w-100" onclick="applyFilters()">Filter</button>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Deskripsi</th>
                                <th>IP Address</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activityLogs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($log->user)
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/images/user/' . ($log->user->avatar ?? 'avatar-default.jpg')) }}"
                                                     alt="{{ $log->user->name }}"
                                                     class="rounded-circle me-2"
                                                     style="width: 30px; height: 30px; object-fit: cover;">
                                                {{ $log->user->name }}
                                            </div>
                                        @else
                                            <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $log->action === 'login' ? 'success' : ($log->action === 'logout' ? 'secondary' : ($log->action === 'delete' ? 'danger' : 'primary')) }}">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($log->description, 50) }}</td>
                                    <td>{{ $log->ip_address ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="btn btn-sm btn-outline-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.activity-logs.destroy', $log) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus log ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="ti ti-file-x display-1 text-muted"></i>
                                        <p class="mt-2 text-muted">Belum ada aktivitas yang tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $activityLogs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const action = document.getElementById('action_filter').value;
    const userId = document.getElementById('user_filter').value;
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = document.getElementById('date_to').value;

    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (action) params.append('action', action);
    if (userId) params.append('user_id', userId);
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);

    window.location.href = '{{ route("admin.activity-logs.index") }}?' + params.toString();
}

function exportLogs() {
    // Implement export functionality
    alert('Fitur export akan segera hadir!');
}

function clearOldLogs() {
    if (confirm('Apakah Anda yakin ingin menghapus log aktivitas yang lebih dari 30 hari?')) {
        // Implement clear old logs functionality
        alert('Fitur hapus log lama akan segera hadir!');
    }
}
</script>
@endsection
@extends('layouts.dashboard')

@section('title', 'Detail Log Aktivitas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Log Aktivitas</h5>
                <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Waktu:</th>
                                <td>{{ $activityLog->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>User:</th>
                                <td>
                                    @if($activityLog->user)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('assets/images/user/' . ($activityLog->user->avatar ?? 'avatar-default.jpg')) }}"
                                                 alt="{{ $activityLog->user->name }}"
                                                 class="rounded-circle me-2"
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $activityLog->user->name }}</strong><br>
                                                <small class="text-muted">{{ $activityLog->user->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Aksi:</th>
                                <td>
                                    <span class="badge bg-{{ $activityLog->action === 'login' ? 'success' : ($activityLog->action === 'logout' ? 'secondary' : ($activityLog->action === 'delete' ? 'danger' : 'primary')) }} fs-6">
                                        {{ ucfirst($activityLog->action) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Model:</th>
                                <td>
                                    @if($activityLog->model_type && $activityLog->model_id)
                                        {{ class_basename($activityLog->model_type) }} #{{ $activityLog->model_id }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>IP Address:</th>
                                <td>{{ $activityLog->ip_address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>User Agent:</th>
                                <td>
                                    <small class="text-muted">{{ $activityLog->user_agent ?? '-' }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="card border">
                            <div class="card-header">
                                <h6 class="mb-0">Deskripsi Aktivitas</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $activityLog->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($activityLog->old_values || $activityLog->new_values)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Perubahan Data:</h6>
                            <div class="row">
                                @if($activityLog->old_values)
                                    <div class="col-md-6">
                                        <div class="card border-danger">
                                            <div class="card-header bg-danger text-white">
                                                <h6 class="mb-0">Data Lama</h6>
                                            </div>
                                            <div class="card-body">
                                                <pre class="mb-0"><code>{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($activityLog->new_values)
                                    <div class="col-md-6">
                                        <div class="card border-success">
                                            <div class="card-header bg-success text-white">
                                                <h6 class="mb-0">Data Baru</h6>
                                            </div>
                                            <div class="card-body">
                                                <pre class="mb-0"><code>{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
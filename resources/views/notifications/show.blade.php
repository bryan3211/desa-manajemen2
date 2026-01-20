@extends('layouts.dashboard', [
    'avatar' => $avatar,
    'name' => $name,
    'role' => $role,
    'unreadNotifications' => $unreadNotifications,
])

@section('title', 'Detail Notifikasi')

@section('content')
<div class="pc-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notifikasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Detail Notifikasi</h5>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="ti ti-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-1 text-center">
                            @php
                                // Show user avatar for surat/pengaduan, admin avatar for biodata
                                $showAvatar = false;
                                $avatarUrl = null;
                                $personName = null;
                                
                                if ($notification->related_type === 'biodata' && $notification->admin()) {
                                    $admin = $notification->admin();
                                    if ($admin->provider) {
                                        // SSO provider - use URL directly
                                        $avatarUrl = $admin->avatar;
                                    } else {
                                        // Local user - construct asset path
                                        $avatarUrl = asset('assets/images/user/' . ($admin->avatar ?? 'avatar-5.jpg'));
                                    }
                                    $personName = $admin->name;
                                    $showAvatar = true;
                                } elseif (in_array($notification->related_type, ['surat', 'pengaduan']) && $notification->actor) {
                                    $actor = $notification->actor;
                                    if ($actor->provider) {
                                        // SSO provider - use URL directly
                                        $avatarUrl = $actor->avatar;
                                    } else {
                                        // Local user - construct asset path
                                        $avatarUrl = asset('assets/images/user/' . ($actor->avatar ?? 'avatar-5.jpg'));
                                    }
                                    $personName = $actor->name;
                                    $showAvatar = true;
                                }
                            @endphp
                            @if($showAvatar && $avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="user-avatar" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover; border: 3px solid #1ba34a;">
                                <p class="small mt-2 text-muted">{{ $personName }}</p>
                            @else
                                <div class="avatar-icon rounded-circle" style="
                                    width: 60px; 
                                    height: 60px; 
                                    display: flex; 
                                    align-items: center; 
                                    justify-content: center;
                                    background: {{ $notification->icon_bg_color }};
                                    color: {{ $notification->icon_text_color }};
                                    font-size: 1.5rem;
                                    font-weight: 600;
                                ">
                                    {{ $notification->icon_emoji }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-11">
                            <h4 class="mb-1">{{ $notification->title }}</h4>
                            <p class="text-muted mb-1">
                                <i class="ti ti-clock me-1"></i>
                                {{ $notification->created_at->format('d F Y H:i') }} ({{ $notification->created_at->diffForHumans() }})
                            </p>
                            @if($notification->related_type === 'biodata' && $notification->admin())
                                <p class="text-muted mb-1">
                                    <i class="ti ti-user me-1"></i>
                                    Dari: <strong>{{ $notification->admin()->name }}</strong> (Admin)
                                </p>
                            @elseif(in_array($notification->related_type, ['surat', 'pengaduan']) && $notification->actor)
                                <p class="text-muted mb-1">
                                    <i class="ti ti-user me-1"></i>
                                    Dari: <strong>{{ $notification->actor->name }}</strong> (Pengguna)
                                </p>
                            @endif
                            <p class="text-muted">
                                <span class="badge" style="
                                    background: {{ $notification->icon_bg_color }};
                                    color: {{ $notification->icon_text_color }};
                                ">
                                    {{ ucfirst(str_replace('-', ' ', $notification->type)) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="alert alert-light border" style="border-left: 4px solid #1ba34a;">
                        <p class="mb-0">{{ $notification->message }}</p>
                    </div>

                    @if($notification->related_type === 'biodata' && $notification->related_id)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6 class="mb-3">Aksi Terkait</h6>
                                <a href="{{ route('user.biodata.show') }}" class="btn btn-primary">
                                    <i class="ti ti-eye me-2"></i>Lihat Biodata
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4 pt-4 border-top">
                        <div class="col-md-12">
                            <small class="text-muted">
                                <strong>ID Notifikasi:</strong> {{ $notification->id }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->
</div>

<style>
    .card {
        box-shadow: 0 4px 15px rgba(27, 163, 74, 0.08);
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    
    .card-header {
        background: linear-gradient(135deg, #f0fdf9 0%, #dcfce7 100%);
        border-bottom: 2px solid #1ba34a;
        border-radius: 12px 12px 0 0 !important;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%);
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(27, 163, 74, 0.2);
    }
</style>
@endsection

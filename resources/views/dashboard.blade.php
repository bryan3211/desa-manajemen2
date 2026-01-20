@extends('layouts.dashboard', [
    'avatar' => $avatar,
    'name' => $name,
    'role' => $role,
    'unreadNotifications' => $unreadNotifications,
])

@section('title', 'Dashboard - Sistem Informasi Desa')

@section('content')
<div class="pc-content" style="background: linear-gradient(135deg, #f0fdf9 0%, #ecfdf5 100%);">
    <!-- [ Header Welcome ] -->
    <div class="rounded-4 shadow-md p-5 mb-4" style="background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%); color: #fff; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; right: 0; opacity: 0.1; font-size: 150px;">
            <i class="ti ti-dashboard"></i>
        </div>
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2" style="font-size: 2.5rem;">Selamat Datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="mb-0 fs-5 opacity-90">Sistem Informasi Desa Digital — Kelola data dan layanan desa dengan mudah dan transparan.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="badge px-4 py-3 shadow-sm" style="font-size: 0.95rem; background: rgba(255,255,255,0.2); color: #fff; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="ti ti-badge me-2"></i><strong>{{ ucfirst(auth()->user()->role) }}</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- [ Bubble Menu Navigation ] -->
    <style>
        .bubble-menu-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 3rem;
            justify-content: flex-start;
        }

        .bubble-menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem;
            border-radius: 20px;
            background: white;
            text-decoration: none;
            color: #1f2937;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(27, 163, 74, 0.08);
            flex: 0 1 calc(25% - 1.125rem);
            min-width: 150px;
            border: 2px solid transparent;
        }

        .bubble-menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(27, 163, 74, 0.2);
            background: linear-gradient(135deg, #f0fdf9 0%, #dcfce7 100%);
            border-color: #1ba34a;
        }

        .bubble-menu-item:active {
            transform: translateY(-5px);
        }

        .bubble-menu-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transition: all 0.3s ease;
        }

        .bubble-menu-item:hover .bubble-menu-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .bubble-menu-text {
            font-weight: 600;
            font-size: 1.1rem;
            color: #1f2937;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .bubble-menu-item:hover .bubble-menu-text {
            color: #1ba34a;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .bubble-menu-item {
                flex: 0 1 calc(33.333% - 1.125rem);
                padding: 1.75rem;
            }

            .bubble-menu-icon {
                font-size: 2.5rem;
                margin-bottom: 0.75rem;
            }

            .bubble-menu-text {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            .bubble-menu-container {
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .bubble-menu-item {
                flex: 0 1 calc(50% - 0.5rem);
                padding: 1.5rem 1rem;
                min-width: 130px;
            }

            .bubble-menu-icon {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }

            .bubble-menu-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .bubble-menu-container {
                flex-direction: column;
                gap: 0.75rem;
            }

            .bubble-menu-item {
                flex: 0 1 100%;
                padding: 1.25rem 1rem;
                flex-direction: row;
                justify-content: flex-start;
            }

            .bubble-menu-icon {
                font-size: 1.75rem;
                margin-bottom: 0;
                margin-right: 1rem;
            }

            .bubble-menu-text {
                text-align: left;
            }
        }
    </style>

    <div class="bubble-menu-container">
        @if (auth()->user()->role == 'admin')
            <a href="{{ route('admin.biodata.index') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-users"></i></div>
                <div class="bubble-menu-text">Kelola Biodata</div>
            </a>
            <a href="{{ route('admin.pengaduan.index') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-alert-circle"></i></div>
                <div class="bubble-menu-text">Kelola Pengaduan</div>
            </a>
            <a href="{{ route('admin.surat.index') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-file-text"></i></div>
                <div class="bubble-menu-text">Kelola Surat</div>
            </a>
        @else
            <a href="{{ route('user.biodata.show') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-user"></i></div>
                <div class="bubble-menu-text">Biodata Saya</div>
            </a>
            <a href="{{ route('user.surat.index') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-file-text"></i></div>
                <div class="bubble-menu-text">Pengajuan Surat</div>
            </a>
            <a href="{{ route('user.pengaduan.index') }}" class="bubble-menu-item">
                <div class="bubble-menu-icon"><i class="ti ti-alert-circle"></i></div>
                <div class="bubble-menu-text">Pengaduan</div>
            </a>
        @endif
    </div>

    <!-- [ Konten Berdasarkan Role ] -->
    @if (auth()->user()->role == 'admin')
        @include('admin.dashboard')
    @else
        @include('user.dashboard')
    @endif
</div>

<!-- [ Custom Styles Inline ] -->
<style>
    .text-toska {
        color: #1ba34a !important;
    }
    .card {
        transition: 0.3s all ease-in-out;
        border: none;
        box-shadow: 0 4px 15px rgba(27, 163, 74, 0.08);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(27, 163, 74, 0.15);
    }
    .bg-light-success {
        background: rgba(27, 163, 74, 0.1);
    }
    .bg-light-primary {
        background: rgba(59, 130, 246, 0.1);
    }
    .bg-light-info {
        background: rgba(6, 182, 212, 0.1);
    }
    .bg-light-warning {
        background: rgba(245, 158, 11, 0.1);
    }
</style>

<!-- [ Chart JS Script ] -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('desaChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Layanan Surat',
                data: [42, 65, 58, 72, 80, 95],
                borderColor: '#1abc9c',
                backgroundColor: 'rgba(26, 188, 156, 0.2)',
                tension: 0.4,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush
@endsection

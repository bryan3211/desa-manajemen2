<!-- Admin Sidebar Items -->
<li class="pc-item {{ request()->is('admin/biodata*') ? 'active' : '' }}">
    <a href="{{ route('admin.biodata.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-user-check"></i></span>
        <span class="pc-mtext">Data Penduduk</span>
    </a>
</li>

<li class="pc-item {{ request()->is('admin/surat*') ? 'active' : '' }}">
    <a href="{{ route('admin.surat.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-file-text"></i></span>
        <span class="pc-mtext">Pengajuan Surat</span>
    </a>
</li>

<li class="pc-item {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
    <a href="{{ route('admin.pengaduan.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-message-circle"></i></span>
        <span class="pc-mtext">Pengaduan Masyarakat</span>
    </a>
</li>

<li class="pc-item {{ request()->is('admin/agendas*') ? 'active' : '' }}">
    <a href="{{ route('admin.agenda.index') }}" class="pc-link">
        <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
        <span class="pc-mtext">Agenda Desa</span>
    </a>
</li>

<li class="pc-item-divider my-2"></li>

<li class="pc-item">
    <a href="{{ route('logout') }}" class="pc-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <span class="pc-micon"><i class="ti ti-logout"></i></span>
        <span class="pc-mtext">Logout</span>
    </a>
</li>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<style>
    /* Admin Sidebar Enhancement */
    .pc-sidebar {
        background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .pc-sidebar .m-header {
        background: rgba(255, 255, 255, 0.1);
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding: 1.5rem 1rem;
        backdrop-filter: blur(10px);
    }

    .pc-sidebar .b-brand {
        color: #ffffff !important;
        font-size: 1.3rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .pc-navbar .pc-item {
        margin: 0.5rem 0.75rem;
        border-radius: 12px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .pc-navbar .pc-item .pc-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255, 255, 255, 0.85) !important;
        padding: 0.875rem 1rem;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
    }

    .pc-navbar .pc-item .pc-link:hover {
        background: rgba(255, 255, 255, 0.15) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .pc-navbar .pc-item.active .pc-link {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
        box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.1), 0 4px 12px rgba(0, 0, 0, 0.15);
        border-left: 4px solid #fbbf24;
        padding-left: calc(1rem - 4px);
    }

    .pc-navbar .pc-item .pc-micon {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        width: 24px;
        height: 24px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.3rem;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .pc-navbar .pc-item .pc-link:hover .pc-micon {
        transform: scale(1.1);
        color: #fbbf24;
    }

    .pc-navbar .pc-item.active .pc-micon {
        color: #fbbf24;
        transform: scale(1.15);
    }

    .pc-navbar .pc-item .pc-mtext {
        font-size: 0.95rem;
        font-weight: 500;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
        flex: 1;
    }

    .pc-item-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
        margin: 1rem 0.75rem;
    }

    /* Icons animation */
    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    .pc-navbar .pc-item .pc-link:hover .pc-micon {
        animation: iconPulse 0.6s ease;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .pc-sidebar {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%) !important;
        }

        .pc-navbar .pc-item .pc-link {
            padding: 0.75rem 0.875rem;
        }

        .pc-navbar .pc-item .pc-mtext {
            font-size: 0.9rem;
        }

        .pc-sidebar .m-header {
            padding: 1rem 0.75rem;
        }
    }
</style>

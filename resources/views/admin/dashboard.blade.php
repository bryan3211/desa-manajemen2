    <div class="row g-4">
        <!-- Total Penduduk -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="border-left: 4px solid #1ba34a;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1 text-muted fw-500">Total Penduduk</h6>
                            <h2 class="mb-0 fw-bold" style="color: #1ba34a;">{{ \App\Models\Biodata::count() }}</h2>
                        </div>
                        <div class="p-3 rounded-2" style="background: rgba(27, 163, 74, 0.1);">
                            <i class="ti ti-users fs-5" style="color: #1ba34a;"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="ti ti-trending-up me-1" style="color: #1ba34a;"></i>Data penduduk terdaftar</small>
                </div>
            </div>
        </div>

        <!-- Biodata Terverifikasi -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="border-left: 4px solid #10b981;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1 text-muted fw-500">Biodata Verifikasi</h6>
                            <h2 class="mb-0 fw-bold" style="color: #10b981;">{{ \App\Models\Biodata::where('status_verifikasi', 'terverifikasi')->count() }}</h2>
                        </div>
                        <div class="p-3 rounded-2" style="background: rgba(16, 185, 129, 0.1);">
                            <i class="ti ti-check fs-5" style="color: #10b981;"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="ti ti-trending-up me-1" style="color: #10b981;"></i>Sudah diverifikasi</small>
                </div>
            </div>
        </div>

        <!-- Pengajuan Surat -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="border-left: 4px solid #3b82f6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1 text-muted fw-500">Pengajuan Surat</h6>
                            <h2 class="mb-0 fw-bold" style="color: #3b82f6;">{{ \App\Models\Surat::count() }}</h2>
                        </div>
                        <div class="p-3 rounded-2" style="background: rgba(59, 130, 246, 0.1);">
                            <i class="ti ti-file-text fs-5" style="color: #3b82f6;"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="ti ti-trending-up me-1" style="color: #3b82f6;"></i>Surat masuk</small>
                </div>
            </div>
        </div>

        <!-- Surat Belum Diverifikasi -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-3 h-100" style="border-left: 4px solid #f59e0b;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h6 class="mb-1 text-muted fw-500">Surat Pending</h6>
                            <h2 class="mb-0 fw-bold" style="color: #f59e0b;">{{ \App\Models\Surat::where('status_verifikasi', 'belum_verifikasi')->count() }}</h2>
                        </div>
                        <div class="p-3 rounded-2" style="background: rgba(245, 158, 11, 0.1);">
                            <i class="ti ti-hourglass fs-5" style="color: #f59e0b;"></i>
                        </div>
                    </div>
                    <small class="text-muted"><i class="ti ti-alert-circle me-1" style="color: #f59e0b;"></i>Menunggu verifikasi</small>
                </div>
            </div>
        </div>

        <!-- Recent Biodata Submissions -->
        <div class="col-md-12 col-xl-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 rounded-top-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-users me-2" style="color: #1ba34a; font-size: 1.3rem;"></i>
                        <h5 class="mb-0 fw-semibold">Data Penduduk Terbaru</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr style="border-bottom: 2px solid #e5e7eb;">
                                    <th style="color: #1ba34a; font-weight: 600;">NIK</th>
                                    <th style="color: #1ba34a; font-weight: 600;">Nama Lengkap</th>
                                    <th style="color: #1ba34a; font-weight: 600;">Status</th>
                                    <th style="color: #1ba34a; font-weight: 600;">Tanggal</th>
                                    <th class="text-end" style="color: #1ba34a; font-weight: 600;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(\App\Models\Biodata::latest()->take(5)->get() as $biodata)
                                    <tr style="border-bottom: 1px solid #f3f4f6; transition: background 0.2s ease;">
                                        <td class="fw-500">{{ $biodata->nik }}</td>
                                        <td>{{ $biodata->nama_lengkap }}</td>
                                        <td>
                                            <span class="badge" style="background: {{ $biodata->status_verifikasi == 'terverifikasi' ? 'rgba(16, 185, 129, 0.2); color: #10b981;' : 'rgba(245, 158, 11, 0.2); color: #f59e0b;' }}">
                                                {{ $biodata->status_verifikasi == 'terverifikasi' ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">{{ $biodata->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.biodata.show', $biodata->id) }}" class="btn btn-sm" style="background: rgba(27, 163, 74, 0.1); color: #1ba34a; border: none;">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Belum ada data penduduk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 text-center rounded-bottom-3">
                    <a href="{{ route('admin.biodata.index') }}" class="btn btn-sm" style="color: #1ba34a; text-decoration: none; font-weight: 600;">Lihat Semua Penduduk →</a>
                </div>
            </div>
        </div>

        <!-- Recent Letter Submissions & Real-time Updates -->
        <div class="col-md-12 col-xl-4 d-flex flex-column gap-4">
            <!-- Recent Letter Submissions -->
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 rounded-top-3">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-file-text me-2" style="color: #1ba34a; font-size: 1.3rem;"></i>
                        <h5 class="mb-0 fw-semibold">Pengajuan Surat Terbaru</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse(\App\Models\Surat::latest()->take(5)->get() as $surat)
                            <a href="{{ route('admin.surat.show', $surat->id) }}" class="list-group-item list-group-item-action border-0 px-0 py-3" style="background: transparent; border-bottom: 1px solid #f3f4f6; transition: background 0.2s ease;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1 small fw-500" style="color: #1f2937;">{{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</h6>
                                        <small class="text-muted">{{ $surat->user?->name ?? 'User' }}</small>
                                    </div>
                                    <span class="badge" style="background: {{ $surat->status_verifikasi == 'terverifikasi' ? 'rgba(16, 185, 129, 0.2); color: #10b981;' : ($surat->status_verifikasi == 'ditolak' ? 'rgba(239, 68, 68, 0.2); color: #ef4444;' : 'rgba(245, 158, 11, 0.2); color: #f59e0b;') }}; font-size: 0.75rem; font-weight: 600;">
                                        {{ ucfirst(str_replace('_', ' ', $surat->status_verifikasi)) }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center text-muted py-4">Belum ada pengajuan surat</div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer bg-light border-0 text-center rounded-bottom-3">
                    <a href="{{ route('admin.surat.index') }}" class="btn btn-sm" style="color: #1ba34a; text-decoration: none; font-weight: 600;">Lihat Semua Pengajuan →</a>
                </div>
            </div>

            <!-- Real-time Status Updates -->
            <div class="card border-0 shadow-sm rounded-3" style="border-top: 4px solid #f97316;">
                <div class="card-header bg-white border-0 rounded-top-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="ti ti-bell me-2" style="color: #1ba34a; font-size: 1.3rem;"></i>
                            <h5 class="mb-0 fw-semibold">Update Status Terbaru</h5>
                        </div>
                        <a href="{{ route('admin.surat.index') }}" class="btn btn-sm" style="color: #1ba34a; text-decoration: none; font-size: 0.85rem;">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body">
                    <div id="adminRecentUpdates">
                        <div class="text-center py-4">
                            <div class="spinner-border spinner-border-sm" style="color: #1ba34a;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
function loadAdminRecentUpdates() {
    const container = document.getElementById('adminRecentUpdates');
    
    fetch('/api/admin/recent-updates', {
        signal: AbortSignal.timeout(8000) // 8 second timeout
    })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data && data.data.length > 0) {
                let html = '<div class="list-group list-group-flush">';
                
                data.data.forEach(update => {
                    const statusEmoji = update.emoji || '⏳';
                    const typeEmoji = update.type === 'surat' ? '📄' : '⚠️';
                    const href = update.tracking_link || '#';
                    
                    html += `
                        <a href="${href}" class="list-group-item list-group-item-action border-0 px-0 py-3" style="background: transparent; border-bottom: 1px solid #f3f4f6; transition: background 0.2s ease;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="font-size: 1.2rem;">${typeEmoji}</span>
                                    <div>
                                        <h6 class="mb-0 small fw-500" style="color: #1f2937;">${update.title}</h6>
                                        <small class="text-muted">Oleh: ${update.updated_by || 'Admin'}</small>
                                    </div>
                                </div>
                                <span class="badge" style="background: ${update.badge_color}; color: ${update.badge_text_color}; font-size: 0.75rem; font-weight: 600;">
                                    ${statusEmoji} ${update.status}
                                </span>
                            </div>
                            ${update.notes ? `<small class="text-muted d-block" style="margin-left: 2rem; margin-top: 0.5rem;">📝 ${update.notes}</small>` : ''}
                            <small class="text-muted d-block" style="margin-left: 2rem; margin-top: 0.25rem;">${update.time_ago}</small>
                        </a>
                    `;
                });
                
                html += '</div>';
                container.innerHTML = html;
            } else {
                container.innerHTML = '<div class="text-center text-muted py-4">Belum ada update status</div>';
            }
        })
        .catch(error => {
            console.error('Error fetching updates:', error);
            // Show cached data or empty state on error
            if (!container.innerHTML.includes('list-group-flush')) {
                container.innerHTML = '<div class="alert alert-light mb-0 text-muted"><small>Tidak dapat memuat update (akan dicoba ulang)</small></div>';
            }
        });
}

// Load on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadAdminRecentUpdates);
} else {
    loadAdminRecentUpdates();
}

// Auto-refresh every 45 seconds (increased from 30)
setInterval(loadAdminRecentUpdates, 45000);
</script>
@endpush

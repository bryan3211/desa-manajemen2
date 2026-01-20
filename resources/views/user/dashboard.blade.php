<div class="row justify-content-center">
    <div class="col-12">
        {{-- Pesan verifikasi email --}}
        @if (!session('verified') && !$user->is_verified)
            <div class="alert alert-warning d-flex align-items-center justify-content-between shadow-sm border-0 rounded-3 mb-4" role="alert" style="background: rgba(245, 158, 11, 0.1); border-left: 4px solid #f59e0b;">
                <div class="d-flex align-items-center">
                    <i class="ti ti-alert-triangle fs-4 me-3" style="color: #f59e0b;"></i>
                    <div>
                        <strong style="color: #1f2937;">Email Anda belum terverifikasi.</strong> 
                        <br>
                        <small style="color: #6b7280;">Silakan verifikasi terlebih dahulu untuk mengakses semua fitur sistem.</small>
                    </div>
                </div>
                <a href="{{ route('verify.form.auth') }}" id="verify-button"
                    class="btn btn-sm fw-bold" style="background: #f59e0b; color: white; border: none; white-space: nowrap; margin-left: 1rem;">
                    Verifikasi Sekarang
                </a>
            </div>
        @endif

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success border-0 rounded-3 mb-4" style="background: rgba(16, 185, 129, 0.1); border-left: 4px solid #10b981; color: #10b981;">
                <i class="ti ti-check me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Real-time Status Updates --}}
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden" style="border-top: 4px solid #f97316;">
                    <div class="card-header bg-white p-4" style="border-bottom: 1px solid #e5e7eb;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-bold" style="color: #1f2937;">
                                <i class="ti ti-bell-ringing me-2" style="color: #f97316;"></i>Update Status Terbaru
                            </h6>
                            <a href="{{ route('user.tracking.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-arrow-right me-1"></i>Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="recentUpdates" class="list-group list-group-flush">
                            <!-- Will be populated by JavaScript -->
                            <div class="p-4 text-center text-muted">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 mb-0">Memuat update terbaru...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3 Kartu Fitur Utama --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden" style="border-top: 4px solid #1ba34a; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem; background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            <i class="ti ti-users"></i>
                        </div>
                        <h5 class="card-title mt-3 fw-bold" style="color: #1f2937;">Data Pribadi</h5>
                        <p class="card-text text-muted">Kelola data pribadi dan informasi lengkap Anda.</p>
                        <a href="{{ route('user.biodata.show') }}" class="btn btn-sm" style="background: rgba(27, 163, 74, 0.1); color: #1ba34a; border: none; text-decoration: none;">
                            Akses →
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden" style="border-top: 4px solid #06b6d4; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem; background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            <i class="ti ti-file-text"></i>
                        </div>
                        <h5 class="card-title mt-3 fw-bold" style="color: #1f2937;">Pelayanan Desa</h5>
                        <p class="card-text text-muted">Ajukan berbagai surat keterangan secara daring.</p>
                        <a href="{{ route('user.surat.index') }}" class="btn btn-sm" style="background: rgba(6, 182, 212, 0.1); color: #06b6d4; border: none; text-decoration: none;">
                            Akses →
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden" style="border-top: 4px solid #8b5cf6; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div style="font-size: 3rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                            <i class="ti ti-alert-circle"></i>
                        </div>
                        <h5 class="card-title mt-3 fw-bold" style="color: #1f2937;">Pengaduan</h5>
                        <p class="card-text text-muted">Sampaikan masalah atau saran kepada desa.</p>
                        <a href="{{ route('user.pengaduan.index') }}" class="btn btn-sm" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6; border: none; text-decoration: none;">
                            Akses →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Profil dan Aksi Cepat --}}
        <div class="row g-4">
            <div class="col-md-6">
                <a href="/myprofile" class="btn btn-lg w-100 fw-bold" style="background: linear-gradient(135deg, #1ba34a 0%, #0f7938 100%); color: white; border: none; padding: 1rem; border-radius: 12px; transition: all 0.3s ease;">
                    <i class="ti ti-user-circle me-2"></i>Lihat Profil Lengkap
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ route('user.surat.create') }}" class="btn btn-lg w-100 fw-bold" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border: none; padding: 1rem; border-radius: 12px; transition: all 0.3s ease;">
                    <i class="ti ti-plus me-2"></i>Ajukan Surat Baru
                </a>
            </div>
        </div>

        <style>
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(27, 163, 74, 0.15) !important;
            }

            .btn-lg:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(27, 163, 74, 0.2) !important;
            }
        </style>
    </div>
</div>

<script>
    // Real-time Status Updates
    function loadRecentUpdates() {
        return fetch('{{ route("api.user.recent-updates") }}', {
            signal: AbortSignal.timeout(8000) // 8 second timeout
        })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('recentUpdates');
                
                if (!data.success || !data.data || data.data.length === 0) {
                    container.innerHTML = `
                        <div class="p-4 text-center text-muted">
                            <i class="ti ti-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                            <p class="mt-2 mb-0">Belum ada update status</p>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.data.forEach(item => {
                    const badgeColor = {
                        'pending': '#f59e0b',
                        'diproses': '#3b82f6',
                        'selesai': '#10b981',
                        'ditolak': '#ef4444',
                        'revisi': '#6b7280'
                    }[item.status] || '#6b7280';

                    const statusIcon = {
                        'pending': '⏳',
                        'diproses': '⚙️',
                        'selesai': '✅',
                        'ditolak': '❌',
                        'revisi': '📝'
                    }[item.status] || '📋';

                    html += `
                        <a href="${item.tracking_link}" class="list-group-item list-group-item-action p-3 border-0 border-bottom" style="text-decoration: none; color: inherit; transition: all 0.3s ease;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="font-size: 1.5rem; margin-right: 0.5rem;">${statusIcon}</span>
                                        <strong style="color: #1f2937;">${item.title}</strong>
                                        <span class="badge ms-2" style="background-color: ${badgeColor}; color: white;">
                                            ${item.status_label}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-1" style="margin-left: 2rem;">
                                        ${item.message}
                                    </p>
                                    <div class="text-muted" style="font-size: 0.8rem; margin-left: 2rem;">
                                        <i class="ti ti-clock me-1"></i>${item.time_ago}
                                    </div>
                                    ${item.notes ? `<div class="alert alert-light mt-2 mb-0 p-2" style="margin-left: 2rem; border-left: 3px solid ${badgeColor}; font-size: 0.9rem;"><strong>Catatan:</strong> ${item.notes}</div>` : ''}
                                </div>
                            </div>
                        </a>
                    `;
                });

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading updates:', error);
                document.getElementById('recentUpdates').innerHTML = `
                    <div class="p-4 text-center text-danger">
                        <i class="ti ti-alert-circle" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Gagal memuat update</p>
                    </div>
                `;
            });
    }

    // Load updates on page load with timeout fallback
    document.addEventListener('DOMContentLoaded', function() {
        // Set fallback timeout to prevent stuck loading
        const updateTimeout = setTimeout(() => {
            const container = document.getElementById('recentUpdates');
            if (container && container.querySelector('.spinner-border')) {
                container.innerHTML = `
                    <div class="p-4 text-center text-muted">
                        <i class="ti ti-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                        <p class="mt-2 mb-0">Tidak dapat memuat update</p>
                    </div>
                `;
            }
        }, 10000);
        
        loadRecentUpdates().catch(() => {
            // Already handled in catch block
        }).finally(() => clearTimeout(updateTimeout));
        
        // Auto-refresh every 45 seconds instead of 30
        setInterval(() => {
            const timeout = setTimeout(() => {
                console.warn('Update fetch timeout - will retry on next interval');
            }, 8000);
            loadRecentUpdates().finally(() => clearTimeout(timeout));
        }, 45000);
    });

    // Script tombol verifikasi loading saat diklik
    const verifyButton = document.getElementById('verify-button');
    if (verifyButton) {
        verifyButton.addEventListener('click', function(e) {
            this.classList.add('disabled');
            this.innerHTML = `
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-right: 0.5rem;"></span>
                Memproses...
            `;
        });
    }
</script>

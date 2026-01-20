<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.5;
            color: #333;
            padding: 20px;
        }
        
        .page {
            max-width: 210mm;
            margin: 0 auto;
            padding: 30mm;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20px;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 12px;
            color: #999;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            background: #1ba34a;
            color: white;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 3px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-group {
            margin-bottom: 12px;
        }
        
        .info-label {
            font-size: 11px;
            color: #666;
            font-weight: bold;
            margin-bottom: 3px;
        }
        
        .info-value {
            font-size: 12px;
            color: #333;
            padding: 5px;
            background: #f9f9f9;
            border-left: 2px solid #1ba34a;
            padding-left: 8px;
        }
        
        .info-full {
            grid-column: 1 / -1;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-diproses {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .status-selesai {
            background: #d1fae5;
            color: #047857;
        }
        
        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
        }
        
        .timeline {
            margin-top: 15px;
        }
        
        .timeline-item {
            display: flex;
            margin-bottom: 15px;
            position: relative;
        }
        
        .timeline-marker {
            width: 12px;
            height: 12px;
            background: #1ba34a;
            border-radius: 50%;
            margin-top: 3px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-date {
            font-size: 11px;
            color: #666;
            font-weight: bold;
        }
        
        .timeline-text {
            font-size: 11px;
            color: #333;
            margin-top: 3px;
        }
        
        .footer {
            text-align: right;
            margin-top: 40px;
            font-size: 11px;
            color: #999;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .page {
                padding: 30mm;
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>{{ env('APP_NAME', 'Desa Management') }}</h1>
            <h2>Laporan Detail Pengaduan</h2>
            <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
        </div>

        <!-- Data Pengaduan -->
        <div class="section">
            <div class="section-title">Informasi Pengaduan</div>
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Nomor Pengaduan</div>
                    <div class="info-value">#{{ $pengaduan->id }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Tanggal Pengaduan</div>
                    <div class="info-value">{{ $pengaduan->created_at->format('d F Y H:i:s') }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Pemohon</div>
                    <div class="info-value">{{ $pengaduan->user->name }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $pengaduan->user->email }}</div>
                </div>
                <div class="info-group info-full">
                    <div class="info-label">Subjek</div>
                    <div class="info-value">{{ $pengaduan->subject }}</div>
                </div>
                <div class="info-group info-full">
                    <div class="info-label">Deskripsi</div>
                    <div class="info-value" style="white-space: pre-wrap; line-height: 1.6;">{{ $pengaduan->description }}</div>
                </div>
            </div>
        </div>

        <!-- Status Pengaduan -->
        <div class="section">
            <div class="section-title">Status Pengaduan</div>
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Status Saat Ini</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                            {{ ucfirst($pengaduan->status) }}
                        </span>
                    </div>
                </div>
                <div class="info-group">
                    <div class="info-label">Prioritas</div>
                    <div class="info-value">{{ ucfirst($pengaduan->priority ?? 'normal') }}</div>
                </div>
            </div>
        </div>

        <!-- Respon Admin -->
        @if($pengaduan->admin_response)
            <div class="section">
                <div class="section-title">Respon dari Admin</div>
                <div class="info-group">
                    <div class="info-label">Respon</div>
                    <div class="info-value" style="white-space: pre-wrap; line-height: 1.6;">{{ $pengaduan->admin_response }}</div>
                </div>
                @if($pengaduan->updated_at && $pengaduan->updated_at != $pengaduan->created_at)
                    <div class="info-group">
                        <div class="info-label">Tanggal Update</div>
                        <div class="info-value">{{ $pengaduan->updated_at->format('d F Y H:i:s') }}</div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Riwayat Perubahan Status -->
        @if($tracking && count($tracking) > 0)
            <div class="section">
                <div class="section-title">Riwayat Perubahan Status</div>
                <div class="timeline">
                    @foreach($tracking as $item)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $item->created_at->format('d F Y H:i:s') }}</div>
                                <div class="timeline-text">
                                    Status berubah menjadi: <strong>{{ ucfirst($item->status) }}</strong>
                                    @if($item->notes)
                                        <br>Catatan: {{ $item->notes }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>© {{ now()->year }} {{ env('APP_NAME', 'Desa Management') }} - Semua Hak Dilindungi</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat - {{ $surat->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .page {
            max-width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 30mm;
            background: white;
            box-shadow: 0 0 1px rgba(0,0,0,0.3);
            page-break-after: always;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 13px;
            color: #666;
        }
        
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            background: #f5f5f5;
            padding: 8px 12px;
            margin-bottom: 10px;
            border-left: 4px solid #1ba34a;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            flex: 1;
            color: #333;
            word-break: break-word;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
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
            margin-top: 20px;
            border-left: 2px solid #ddd;
            padding-left: 15px;
        }
        
        .timeline-item {
            margin-bottom: 15px;
            padding-left: 0;
            position: relative;
        }
        
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -20px;
            top: 2px;
            width: 12px;
            height: 12px;
            background: #1ba34a;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        .timeline-title {
            font-weight: bold;
            font-size: 12px;
            color: #333;
        }
        
        .timeline-date {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }
        
        .timeline-note {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
            font-style: italic;
        }
        
        .user-info {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 15px;
        }
        
        .footer {
            text-align: right;
            margin-top: 40px;
            font-size: 11px;
            color: #999;
        }
        
        .print-only {
            display: block;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .page {
                max-width: 100%;
                min-height: 100%;
                margin: 0;
                padding: 30mm;
                box-shadow: none;
                page-break-after: always;
            }
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .page {
                padding: 15mm;
            }
            
            .info-label {
                width: 120px;
            }
            
            .header h1 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <h1>{{ env('APP_NAME', 'Desa Management') }}</h1>
            <p>Dokumen Pengajuan Surat</p>
        </div>

        <!-- Main Info -->
        <div class="user-info">
            <strong>Pemohon:</strong> {{ $surat->user->name }}<br>
            <strong>Email:</strong> {{ $surat->user->email }}<br>
            <strong>NIK:</strong> {{ $surat->user->nik }}
        </div>

        <!-- Surat Details -->
        <div class="section">
            <div class="section-title">Informasi Pengajuan</div>
            <div class="info-row">
                <span class="info-label">No. Permohonan</span>
                <span class="info-value">#{{ $surat->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jenis Surat</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Pengajuan</span>
                <span class="info-value">{{ $surat->created_at->format('d F Y H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">
                    <span class="status-badge status-{{ strtolower(str_replace('_', '-', $surat->status_verifikasi)) }}">
                        {{ ucfirst(str_replace('_', ' ', $surat->status_verifikasi)) }}
                    </span>
                </span>
            </div>
        </div>

        <!-- Data Details -->
        <div class="section">
            <div class="section-title">Data Pengajuan</div>
            @if($surat->data)
                @foreach($surat->data as $key => $value)
                    <div class="info-row">
                        <span class="info-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                        <span class="info-value">{{ is_array($value) ? implode(', ', $value) : $value }}</span>
                    </div>
                @endforeach
            @else
                <p style="font-size: 12px; color: #999;">Tidak ada data pengajuan</p>
            @endif
        </div>

        <!-- Tracking History -->
        @if($tracking && count($tracking) > 0)
        <div class="section">
            <div class="section-title">Riwayat Update</div>
            <div class="timeline">
                @foreach($tracking as $item)
                    <div class="timeline-item">
                        <div class="timeline-title">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</div>
                        <div class="timeline-date">{{ $item->created_at->format('d F Y H:i') }}</div>
                        @if($item->notes)
                            <div class="timeline-note">Catatan: {{ $item->notes }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Dokumen ini dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
            <p>{{ env('APP_NAME', 'Desa Management') }} - Sistem Manajemen Desa</p>
        </div>
    </div>
</body>
</html>

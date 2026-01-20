<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Surat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
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
            font-size: 22px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 13px;
            color: #666;
        }
        
        .summary {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #1ba34a;
        }
        
        .summary-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        thead {
            background: #1ba34a;
            color: white;
        }
        
        th {
            padding: 10px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        
        td {
            padding: 8px 10px;
            font-size: 11px;
            border-bottom: 1px solid #eee;
        }
        
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        tbody tr:hover {
            background: #f0f7f3;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            white-space: nowrap;
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
        
        .footer {
            text-align: right;
            margin-top: 40px;
            font-size: 11px;
            color: #999;
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
            <p>Laporan Pengajuan Surat</p>
            <p style="font-size: 12px; color: #999;">Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-item">
                <div class="summary-number">{{ count($surats) }}</div>
                <div class="summary-label">Total Surat</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($surats->where('status_verifikasi', 'terverifikasi')) }}</div>
                <div class="summary-label">Terverifikasi</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($surats->where('status_verifikasi', 'diproses')) }}</div>
                <div class="summary-label">Diproses</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($surats->where('status_verifikasi', 'belum_verifikasi')) }}</div>
                <div class="summary-label">Pending</div>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surats as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->user->name }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $surat->jenis_surat)) }}</td>
                        <td>{{ $surat->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace('_', '-', $surat->status_verifikasi)) }}">
                                {{ ucfirst(str_replace('_', ' ', $surat->status_verifikasi)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">Tidak ada data surat</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ now()->year }} {{ env('APP_NAME', 'Desa Management') }} - Semua Hak Dilindungi</p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Semua Pengaduan</title>
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
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            gap: 10px;
        }
        
        .summary-item {
            text-align: center;
        }
        
        .summary-number {
            font-size: 20px;
            font-weight: bold;
            color: #1ba34a;
        }
        
        .summary-label {
            font-size: 11px;
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
            font-size: 11px;
            font-weight: bold;
        }
        
        td {
            padding: 8px 10px;
            font-size: 10px;
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
            font-size: 9px;
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
        
        .priority-high {
            color: #dc2626;
            font-weight: bold;
        }
        
        .priority-normal {
            color: #2563eb;
        }
        
        .priority-low {
            color: #059669;
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
            <p>Laporan Data Pengaduan</p>
            <p style="font-size: 12px; color: #999;">Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-item">
                <div class="summary-number">{{ count($pengaduans) }}</div>
                <div class="summary-label">Total Pengaduan</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($pengaduans->where('status', 'pending')) }}</div>
                <div class="summary-label">Pending</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($pengaduans->where('status', 'diproses')) }}</div>
                <div class="summary-label">Diproses</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($pengaduans->where('status', 'selesai')) }}</div>
                <div class="summary-label">Selesai</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ count($pengaduans->where('status', 'ditolak')) }}</div>
                <div class="summary-label">Ditolak</div>
            </div>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pemohon</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengaduans as $index => $pengaduan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pengaduan->user->name }}</td>
                        <td>{{ Str::limit($pengaduan->subject, 30, '...') }}</td>
                        <td>{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                        <td>
                            <span class="priority-{{ strtolower($pengaduan->priority ?? 'normal') }}">
                                {{ ucfirst($pengaduan->priority ?? 'Normal') }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower($pengaduan->status) }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">Tidak ada data pengaduan</td>
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

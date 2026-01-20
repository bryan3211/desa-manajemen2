<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Biodata</title>
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
            margin-bottom: 20px;
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
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .status-verified {
            background: #d1fae5;
            color: #047857;
        }
        
        .status-unverified {
            background: #fef3c7;
            color: #92400e;
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
            <h2>Laporan Biodata Penduduk</h2>
            <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
        </div>

        <!-- Data Pribadi -->
        <div class="section">
            <div class="section-title">Data Pribadi</div>
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $biodata->nama_lengkap ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">NIK</div>
                    <div class="info-value">{{ $biodata->nik ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Tanggal Lahir</div>
                    <div class="info-value">{{ $biodata->tanggal_lahir ? \Carbon\Carbon::parse($biodata->tanggal_lahir)->format('d F Y') : '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">{{ $biodata->jenis_kelamin ? ucfirst($biodata->jenis_kelamin) : '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Agama</div>
                    <div class="info-value">{{ $biodata->agama ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Status Perkawinan</div>
                    <div class="info-value">{{ $biodata->status_perkawinan ? ucfirst(str_replace('_', ' ', $biodata->status_perkawinan)) : '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="section">
            <div class="section-title">Alamat</div>
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Alamat Lengkap</div>
                    <div class="info-value">{{ $biodata->alamat ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">RT/RW</div>
                    <div class="info-value">{{ ($biodata->rt ?? '-') . '/' . ($biodata->rw ?? '-') }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Kelurahan</div>
                    <div class="info-value">{{ $biodata->kelurahan ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Kecamatan</div>
                    <div class="info-value">{{ $biodata->kecamatan ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Kota/Kabupaten</div>
                    <div class="info-value">{{ $biodata->kota ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Provinsi</div>
                    <div class="info-value">{{ $biodata->provinsi ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Data Kontak -->
        <div class="section">
            <div class="section-title">Data Kontak</div>
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $biodata->user->email ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Nomor Telepon</div>
                    <div class="info-value">{{ $biodata->nomor_telepon ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Status Verifikasi -->
        <div class="section">
            <div class="section-title">Status Verifikasi</div>
            <div class="info-group">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge status-{{ $biodata->is_verified ? 'verified' : 'unverified' }}">
                        {{ $biodata->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                    </span>
                </div>
            </div>
            @if($biodata->is_verified)
                <div class="info-group">
                    <div class="info-label">Tanggal Verifikasi</div>
                    <div class="info-value">{{ $biodata->updated_at->format('d F Y H:i:s') }}</div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© {{ now()->year }} {{ env('APP_NAME', 'Desa Management') }} - Semua Hak Dilindungi</p>
        </div>
    </div>
</body>
</html>

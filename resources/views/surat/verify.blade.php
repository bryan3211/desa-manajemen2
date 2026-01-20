<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Tanda Tangan Digital - Desa Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            min-height: 100vh;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .verification-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 20px;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUp 0.6s ease-out forwards;
        }

        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .status-header {
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .status-header.valid {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
        }

        .status-header.invalid {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        .status-header.not_found {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .status-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            display: block;
        }

        .status-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .status-message {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
        }

        .content {
            padding: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            border-left: 4px solid #3b82f6;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .info-card.valid {
            border-left-color: #22c55e;
        }

        .info-card.invalid {
            border-left-color: #ef4444;
        }

        .info-card.not_found {
            border-left-color: #f59e0b;
        }

        .info-label {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            word-break: break-word;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: white;
            opacity: 0.8;
        }

        .footer p {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .footer .powered-by {
            font-size: 0.8rem;
            opacity: 0.6;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.valid {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
        }

        .badge.invalid {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .badge.not_found {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .status-title {
                font-size: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 20px;
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-shield-alt"></i> Verifikasi Digital</h1>
            <p>Sistem Verifikasi Tanda Tangan Elektronik Desa</p>
        </div>

        <div class="verification-card">
            @if($status === 'not_found')
                <div class="status-header not_found">
                    <i class="fas fa-exclamation-triangle status-icon pulse"></i>
                    <div class="status-title">Surat Tidak Ditemukan</div>
                    <div class="status-message">{{ $message }}</div>
                </div>
            @else
                <div class="status-header {{ $status }}">
                    @if($status === 'valid')
                        <i class="fas fa-check-circle status-icon pulse"></i>
                        <div class="status-title">Tanda Tangan Valid</div>
                        <div class="status-message">Dokumen ini telah diverifikasi dan sah</div>
                    @else
                        <i class="fas fa-times-circle status-icon pulse"></i>
                        <div class="status-title">Tanda Tangan Tidak Valid</div>
                        <div class="status-message">Dokumen mungkin telah dimanipulasi</div>
                    @endif
                </div>

                <div class="content">
                    <div class="info-grid">
                        <div class="info-card {{ $status }}">
                            <div class="info-label"><i class="fas fa-id-card"></i> ID Surat</div>
                            <div class="info-value">{{ $surat->id }}</div>
                        </div>

                        <div class="info-card {{ $status }}">
                            <div class="info-label"><i class="fas fa-file-alt"></i> Jenis Surat</div>
                            <div class="info-value">{{ $surat->jenis_surat }}</div>
                        </div>

                        <div class="info-card {{ $status }}">
                            <div class="info-label"><i class="fas fa-user"></i> Pengaju</div>
                            <div class="info-value">{{ $surat->user->name ?? '-' }}</div>
                        </div>

                        <div class="info-card {{ $status }}">
                            <div class="info-label"><i class="fas fa-user-check"></i> Diverifikasi Oleh</div>
                            <div class="info-value">{{ $surat->approver_name ?? ($surat->verifier?->name ?? '-') }}</div>
                        </div>

                        <div class="info-card {{ $status }}">
                            <div class="info-label"><i class="fas fa-calendar"></i> Tanggal Verifikasi</div>
                            <div class="info-value">{{ $timestamp ?? now()->format('d F Y H:i') }}</div>
                        </div>
                    </div>

                    @if($status === 'valid')
                        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px; margin-top: 20px; text-align: center;">
                            <i class="fas fa-shield-alt" style="font-size: 2rem; color: #16a34a; margin-bottom: 10px;"></i>
                            <p style="color: #166534; font-weight: 600; margin: 0;">
                                <i class="fas fa-check-circle"></i> Surat ini telah diverifikasi dan sah secara digital
                            </p>
                        </div>
                    @else
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 20px; margin-top: 20px; text-align: center;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #dc2626; margin-bottom: 10px;"></i>
                            <p style="color: #991b1b; font-weight: 600; margin: 0;">
                                <i class="fas fa-times-circle"></i> Tanda tangan tidak valid - kemungkinan dokumen telah diubah
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="footer">
            <p><i class="fas fa-building"></i> Sistem Informasi Desa Digital</p>
            <p class="powered-by">Powered by Laravel & QR Technology</p>
        </div>
    </div>
</body>
</html>
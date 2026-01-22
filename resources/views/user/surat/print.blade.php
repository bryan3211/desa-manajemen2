<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Cetak Surat Keterangan - {{ $surat->id }}</title>
    <style>
        @page {
            margin: 20px 30px;
            size: A4;
        }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color:#000;
            margin: 0;
            font-size: 13px;
            line-height: 1.4;
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
            box-sizing: border-box;
        }

        .header { display:flex; align-items:flex-start; margin-bottom: 10px; }
        .logo { width:70px; margin-right:8px; }
        .gov { text-align:center; flex:1; }
        .gov h1 { margin:0; font-size:16px; font-weight:700; }
        .gov h2 { margin:0; font-size:15px; font-weight:700; }
        .gov p { margin:2px 0; font-size:12px; }
        .separator { border-top:2px solid #000; margin:8px 0 12px 0; }

        .title { text-align:center; font-weight:700; font-size:16px; margin:8px 0 4px 0; }
        .nomor { text-align:center; margin-bottom:12px; font-size:14px; }

        .content {
            font-size:13px;
            line-height:1.5;
            text-align:justify;
            margin:10px 0;
            text-indent: 30px;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .kv { width:100%; margin:8px 0; table-layout: fixed; }
        .kv td { vertical-align:top; padding:1px 4px; font-size:13px; word-wrap: break-word; overflow-wrap: break-word; }
        .bold { font-weight:700; }

        .signature {
            margin-top:20px;
            width:100%;
            text-align:center;
            page-break-inside: avoid;
        }
        .sign-name { margin-top:40px; font-weight:700; text-decoration:underline; font-size:14px; }

        .footer {
            margin-top:20px;
            font-size:10px;
            page-break-inside: avoid;
        }

        /* Force single page */
        html, body {
            height: auto;
            overflow: visible;
        }

        /* Prevent page breaks */
        .header, .title, .nomor, .content, .signature, .footer {
            page-break-inside: avoid;
        }

        /* Compact spacing */
        p { margin: 4px 0; }
        table { margin: 6px 0; }

        /* Force single page layout */
        @page {
            size: A4;
            margin: 20px 30px;
            orphans: 999;
            widows: 999;
        }

        @media print {
            body { margin: 0; }
            .signature { page-break-inside: avoid; }
            .footer { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ asset('assets/images/my/sidoarjo.png') }}" alt="logo" style="width:100%;" />
        </div>
        <div class="gov">
            <h1>PEMERINTAH KABUPATEN SIDOARJO</h1>
            <h2>KECAMATAN WARU</h2>
            <p><strong>KELURAHAN MEDAENG</strong></p>
            <p>Jl. Raya Medaeng No. 01, Waru - Sidoarjo, Kode Pos 61256</p>
            <p>Telp. (031) 8671234, Email: kelmedaeng@sidoarjo.go.id</p>
        </div>
    </div>

    <div class="separator"></div>

    <div class="title">SURAT KETERANGAN</div>
    <div class="nomor">Nomor : <strong>{{ $surat->nomor ?? '/644/402.406.04/2023' }}</strong></div>

    <table class="kv">
        <tr>
            <td style="width:35%">Yang bertandatangan di bawah ini</td>
            <td style="width:3%">:</td>
            <td></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><strong>{{ $surat->approver_name ?? 'Dheny Kurniawan, S.STP' }}</strong></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $surat->approver_title ?? 'Lurah Kelurahan Medaeng' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $surat->approver_nip ?? '19751215 199803 1 001' }}</td>
        </tr>
    </table>

    {{-- Type-specific detail table --}}
    @php $type = $surat->jenis_surat; $d = (array)($surat->data ?? []); @endphp
    @if(in_array($type, ['ktp','surat_kelahiran','sktm','domisili']))
        <table class="kv" style="margin-top: 15px; border: 1px solid #ddd; border-collapse: collapse; table-layout: fixed; width: 100%;">
            <tr style="background-color: #f8f9fa;">
                <td colspan="3" style="padding: 8px; font-weight: 600; border: 1px solid #ddd; text-align: center;">DATA PEMOHON</td>
            </tr>
            @if(in_array($type, ['ktp','sktm','domisili']))
                <tr>
                    <td style="width:25%; padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Nama Lengkap</td>
                    <td style="width:2%; padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['nama_lengkap'] ?? $d['nama'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Nomor Induk Kependudukan</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['nik'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Alamat Lengkap</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['alamat'] ?? $d['alamat_lengkap'] ?? '-' }}</td>
                </tr>
            @endif

            @if($type == 'surat_kelahiran')
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Nama Bayi</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['nama_bayi'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Tanggal Lahir</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['tanggal_lahir'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">Tempat Lahir</td>
                    <td style="padding: 6px; border: 1px solid #ddd;">:</td>
                    <td style="padding: 6px; border: 1px solid #ddd; word-wrap: break-word;">{{ $d['tempat_lahir'] ?? '-' }}</td>
                </tr>
            @endif
        </table>
    @endif

    <div class="content">
        @php $rendered = $rendered_body ?? ($surat->data['keterangan'] ?? null); @endphp

        @if($rendered)
            <p style="text-align: justify; text-indent: 40px; margin-bottom: 12px;">{!! nl2br(e($rendered)) !!}</p>
        @else
            @php $type = $surat->jenis_surat; $d = (array)($surat->data ?? []); @endphp

            @if($type == 'ktp')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Nama: <strong>{{ $d['nama_lengkap'] ?? $d['nama'] ?? '-' }}</strong>, NIK: <strong>{{ $d['nik'] ?? '-' }}</strong>, lahir di {{ $d['tempat_lahir'] ?? '-' }}, tanggal {{ $d['tanggal_lahir'] ?? '-' }}, bertempat tinggal di {{ $d['alamat'] ?? $d['alamat_lengkap'] ?? '-' }}. Surat keterangan ini dibuat untuk keperluan pengajuan Kartu Tanda Penduduk (KTP) sesuai data yang diajukan.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>

            @elseif($type == 'kk')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Nama: <strong>{{ $d['nama_lengkap'] ?? $d['nama'] ?? '-' }}</strong>, NIK: <strong>{{ $d['nik'] ?? '-' }}</strong>, bertempat tinggal di {{ $d['alamat'] ?? $d['alamat_lengkap'] ?? '-' }}. Surat keterangan ini dibuat untuk keperluan pengajuan Kartu Keluarga (KK) sesuai data yang diajukan.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>

            @elseif($type == 'sktm')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Nama: <strong>{{ $d['nama_lengkap'] ?? $d['nama'] ?? '-' }}</strong>, NIK: <strong>{{ $d['nik'] ?? '-' }}</strong>, bertempat tinggal di {{ $d['alamat'] ?? $d['alamat_lengkap'] ?? '-' }}. Berdasarkan verifikasi data dan kondisi ekonomi yang bersangkutan, yang bersangkutan termasuk dalam kategori masyarakat tidak mampu. Surat keterangan ini dibuat untuk keperluan pengajuan Surat Keterangan Tidak Mampu (SKTM) sesuai data yang diajukan.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>

            @elseif($type == 'domisili')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Nama: <strong>{{ $d['nama_lengkap'] ?? $d['nama'] ?? '-' }}</strong>, NIK: <strong>{{ $d['nik'] ?? '-' }}</strong>, bertempat tinggal di {{ $d['alamat'] ?? $d['alamat_lengkap'] ?? '-' }}. Surat keterangan ini dibuat untuk keperluan pengajuan Surat Keterangan Domisili sesuai data yang diajukan.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>

            @elseif($type == 'surat_kelahiran')
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Telah lahir seorang anak bernama <strong>{{ $d['nama_bayi'] ?? '-' }}</strong>, jenis kelamin {{ $d['jenis_kelamin'] ?? '-' }}, pada tanggal {{ $d['tanggal_lahir'] ?? '-' }}, di {{ $d['tempat_lahir'] ?? '-' }}, dari orang tua {{ $d['nama_ayah'] ?? '-' }} dan {{ $d['nama_ibu'] ?? '-' }}. Surat keterangan ini dibuat untuk keperluan pengajuan akta kelahiran sesuai data yang diajukan.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>

            @else
                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Berdasarkan data dan informasi yang tersedia di Kelurahan Medaeng, Kecamatan Waru, Kabupaten Sidoarjo, dengan ini menerangkan bahwa:</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Surat keterangan ini dibuat berdasarkan permohonan yang bersangkutan setelah dilakukan verifikasi terhadap data dan dokumen yang ada. Surat keterangan ini berlaku selama 6 (enam) bulan terhitung sejak tanggal dikeluarkan, kecuali terdapat perubahan data atau keadaan yang mendasar.</p>

                <p style="text-align: justify; text-indent: 40px; margin-bottom: 8px;">Demikian surat keterangan ini dibuat dengan sebenarnya dan diberikan kepada yang bersangkutan untuk dipergunakan sebagaimana mestinya, sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.</p>
            @endif
        @endif
    </div>

    <div class="signature" style="position:relative;">
        <div style="overflow:visible;">
            <p>{{ $surat->place ?? 'Waru' }}, {{ $surat->signed_at ? $surat->signed_at->format('d F Y') : now()->format('d F Y') }}</p>
            <p>{{ $surat->approver_title ?? 'Lurah Kelurahan Medaeng' }}</p>
            <p class="sign-name">{{ $surat->approver_name ?? 'Dheny Kurniawan, S.STP' }}</p>
            <p style="margin-top: 5px;">NIP. {{ $surat->approver_nip ?? '19751215 199803 1 001' }}</p>
        </div>

        @if(!empty($signature_qr))
            <div style="float:right; text-align:center; margin-top:8px; max-width:140px;">
                <img src="{{ $signature_qr }}" alt="QR Signature" style="width:110px; border:1px solid #000; padding:4px; background:#fff; display:block;" />
                <div style="font-size:9px; margin-top:4px;">Tanda tangan digital</div>
            </div>
            <div style="clear:both;"></div>
        @endif
    </div>

    <!-- <div class="footer">
        <p><strong>Tembusan :</strong></p>
        <ol style="margin-top: 10px;">
            <li>Bupati Sidoarjo</li>
            <li>Ketua DPRD Kabupaten Sidoarjo</li>
            <li>Kapolres Sidoarjo</li>
            <li>Kepala Kejaksaan Negeri Sidoarjo</li>
            <li>Camat Waru</li>
            <li>Kepala Desa/Kelurahan se-Kecamatan Waru</li>
            <li>Arsip</li>
        </ol>
    </div> -->

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() { window.print(); }, 200);
        });
    </script>
</body>
</html>
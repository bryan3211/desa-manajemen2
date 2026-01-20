<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Support dari {{ $data['name'] }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .content { background-color: #ffffff; padding: 20px; border: 1px solid #dee2e6; border-radius: 5px; }
        .footer { margin-top: 20px; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Pesan Support Baru</h2>
            <p>Anda menerima pesan support dari pengguna sistem.</p>
        </div>

        <div class="content">
            <h3>Detail Pesan:</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; width: 120px;">Nama:</td>
                    <td style="padding: 8px 0;">{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Email:</td>
                    <td style="padding: 8px 0;">{{ $data['email'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold;">Subjek:</td>
                    <td style="padding: 8px 0;">{{ $data['subject'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; vertical-align: top;">Pesan:</td>
                    <td style="padding: 8px 0;">{{ nl2br(e($data['message'])) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Email ini dikirim dari formulir kontak masyarakat di Sistem Informasi Desa.</p>
            <p>Pesan ini berasal dari: {{ $data['name'] }} - {{ $data['email'] }}</p>
        </div>
    </div>
</body>
</html>
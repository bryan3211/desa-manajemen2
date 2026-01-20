https://docs.google.com/document/d/1Q59z4dxFcN1ZZHwLztWfcUtUFJoAWc8JD7sq6BBh_Io/edit?usp=sharing

# Sistem Manajemen Desa

Sistem manajemen desa berbasis web yang dibangun dengan Laravel untuk mengelola administrasi desa secara digital. Sistem ini menyediakan fitur-fitur modern untuk pengelolaan dokumen, verifikasi QR code, dan komunikasi dengan warga.

## 🚀 Fitur Utama

### 👥 Manajemen Pengguna
- **Autentikasi dengan NIK**: Login menggunakan Nomor Induk Kependudukan (16 digit)
- **Integrasi Google OAuth**: Login alternatif melalui akun Google
- **Manajemen Peran**: Admin dan User (Warga)
- **Biodata Lengkap**: Pengelolaan data kependudukan warga

### 📄 Sistem Surat
- **Berbagai Jenis Surat**:
  - Surat Keterangan Kelahiran
  - Surat Keterangan Kematian
  - Surat KTP
  - Surat Keterangan Domisili
  - Surat Izin Usaha
  - Surat Rekomendasi
  - Kartu Keluarga/KIA
  - Akta Kelahiran
  - Izin IMB
  - Pembetulan Data
- **Verifikasi Admin**: Surat harus diverifikasi admin sebelum dapat dicetak
- **QR Code**: Setiap surat memiliki QR code untuk verifikasi keaslian
- **Auto Numbering**: Penomoran surat otomatis

### 🔍 Verifikasi QR Code
- **URL Lokal**: QR code menggunakan URL sistem internal
- **Informasi Lengkap**: Berisi data surat dan tanda tangan kepala desa
- **Tampilan Modern**: Halaman verifikasi dengan desain hijau profesional
- **Keamanan**: Verifikasi keaslian dokumen secara real-time

### 📊 Dashboard & Statistik
- **Dashboard Admin**: Overview lengkap sistem
- **Dashboard User**: Status pengajuan dan notifikasi
- **Statistik Real-time**: Data pengajuan, verifikasi, dan aktivitas
- **Activity Logging**: Pencatatan semua aktivitas sistem

### 📞 Sistem Komunikasi
- **Form Kontak**: Pusat informasi desa dengan statistik
- **Email Notifikasi**: Otomatis ke email desa
- **Sistem Pengaduan**: Warga dapat menyampaikan aspirasi
- **Review & Rating**: Sistem penilaian layanan

### 📅 Agenda Desa
- **Agenda Publik**: Informasi agenda desa untuk umum
- **Dokumentasi**: Upload foto/dokumen kegiatan
- **Tracking**: Monitoring progress agenda

## 🛠️ Tech Stack

- **Backend**: Laravel 12.0
- **Frontend**: Tailwind CSS 4.0, Vite
- **Database**: MySQL 8.0+
- **Authentication**: Laravel Sanctum, Socialite (Google OAuth)
- **QR Code**: SimpleSoftwareIO QR Code
- **PDF Generation**: DomPDF
- **Email**: SMTP (Gmail)
- **Testing**: Pest PHP

## 📋 Persyaratan Sistem

- **PHP**: 8.2 atau lebih tinggi
- **Composer**: 2.x
- **Node.js**: 18.x atau lebih tinggi
- **NPM**: 9.x atau lebih tinggi
- **MySQL**: 8.0 atau lebih tinggi
- **Web Server**: Apache/Nginx dengan mod_rewrite

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd desa-manajemen2
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Install Dependencies Node.js
```bash
npm install
```

### 4. Environment Configuration
```bash
cp .env.example .env
```

Edit file `.env` dengan konfigurasi database dan email:
```env
APP_NAME="Sistem Manajemen Desa"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_db2
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD="your-app-password"
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Desa Manajemen"
MAIL_ADMIN_EMAIL=admin@desa.local

GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost/auth/google/callback
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Database Setup
```bash
# Buat database di MySQL
# Kemudian jalankan migration dan seeder
php artisan migrate:fresh --seed
```

### 7. Build Assets
```bash
npm run build
# atau untuk development
npm run dev
```

### 8. Storage Link
```bash
php artisan storage:link
```

### 9. Jalankan Aplikasi
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 🔧 Konfigurasi

### Email Configuration
Sistem menggunakan Gmail SMTP untuk mengirim email. Pastikan:
1. Aktifkan 2-Factor Authentication di Gmail
2. Generate App Password
3. Gunakan App Password di konfigurasi MAIL_PASSWORD

### Google OAuth
1. Buat project di Google Cloud Console
2. Aktifkan Google+ API
3. Buat OAuth 2.0 Client ID
4. Konfigurasi redirect URI sesuai environment

### Database
Sistem menggunakan MySQL dengan struktur tabel:
- `users`: Data pengguna dengan NIK
- `biodata`: Data kependudukan lengkap
- `surats`: Data pengajuan surat
- `pengaduan`: Sistem pengaduan warga
- `agendas`: Agenda dan kegiatan desa
- `notifications`: Sistem notifikasi
- `reviews`: Sistem penilaian

## 📖 Penggunaan

### Untuk Admin
1. **Login** dengan akun admin
2. **Dashboard**: Monitor statistik dan aktivitas
3. **Kelola Biodata**: Verifikasi dan kelola data warga
4. **Verifikasi Surat**: Approve/reject pengajuan surat
5. **Kelola Agenda**: Buat dan kelola agenda desa

### Untuk Warga
1. **Registrasi**: Daftar dengan NIK 16 digit
2. **Login**: Masuk dengan NIK atau Google OAuth
3. **Lengkapi Biodata**: Upload dokumen dan data pribadi
4. **Ajukan Surat**: Pilih jenis surat dan isi formulir
5. **Tracking**: Monitor status pengajuan
6. **QR Verification**: Verifikasi keaslian surat

## 🧪 Testing

Jalankan test dengan Pest PHP:
```bash
php artisan test
```

## 📁 Struktur Proyek

```
desa-manajemen2/
├── app/
│   ├── Http/Controllers/     # Controller classes
│   ├── Models/              # Eloquent models
│   ├── Mail/                # Email templates
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   └── views/              # Blade templates
├── routes/
│   └── web.php             # Web routes
├── storage/                 # File storage
├── tests/                  # Test files
├── .env                    # Environment configuration
├── composer.json           # PHP dependencies
└── package.json            # Node dependencies
```

## 🔒 Keamanan

- **NIK Validation**: Validasi ketat 16 digit untuk identitas
- **CSRF Protection**: Laravel CSRF token pada semua form
- **Input Sanitization**: Validasi dan sanitasi input
- **Role-based Access**: Kontrol akses berdasarkan peran
- **Secure Passwords**: Hashing password dengan bcrypt

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📝 Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## 📞 Kontak

- **Email**: admin@desa.local
- **Project**: Sistem Manajemen Desa
- **Version**: 2.0

## 🙏 Acknowledgments

- [Laravel](https://laravel.com/) - The PHP Framework
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [SimpleSoftwareIO QR Code](https://www.simplesoftware.io/#/docs/simple-qrcode) - QR Code generator
- [DomPDF](https://github.com/barryvdh/laravel-dompdf) - PDF generation
- [Laravel Socialite](https://laravel.com/docs/socialite) - OAuth integration

---

**Catatan**: Pastikan semua konfigurasi environment sudah benar sebelum menjalankan aplikasi di production. Backup database secara berkala untuk keamanan data.</content>
<parameter name="filePath">c:\xampp\htdocs\desa-manajemen2\README.md
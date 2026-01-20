#!/usr/bin/env php
<?php
/**
 * Email Configuration Tester
 * Usage: php test-email.php
 */

require __DIR__ . '/bootstrap/app.php';

use Illuminate\Support\Facades\Mail;

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

echo "
╔════════════════════════════════════════════════════════════════╗
║           Email Configuration Tester for Gmail SMTP            ║
╚════════════════════════════════════════════════════════════════╝

";

// Check environment variables
echo "📋 Checking Configuration:\n";
echo "─ MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "─ MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "─ MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "─ MAIL_ENCRYPTION: " . env('MAIL_ENCRYPTION') . "\n";
echo "─ MAIL_USERNAME: " . env('MAIL_USERNAME') . "\n";
echo "─ MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS') . "\n";

echo "\n🔐 Security Check:\n";

// Validate configuration
$errors = [];

if (!env('MAIL_USERNAME') || env('MAIL_USERNAME') === 'your-email@gmail.com') {
    $errors[] = "❌ MAIL_USERNAME tidak dikonfigurasi. Edit .env file Anda.";
}

if (!env('MAIL_PASSWORD') || env('MAIL_PASSWORD') === 'your-app-password') {
    $errors[] = "❌ MAIL_PASSWORD tidak dikonfigurasi. Gunakan App Password dari Google Account Anda.";
}

if (env('APP_ENV') === 'production' && env('APP_DEBUG') === true) {
    $errors[] = "⚠️  APP_DEBUG=true di production (security risk)";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "\n";
    }
    echo "\n📚 Lihat SETUP_EMAIL_GMAIL.md untuk instruksi lengkap.\n";
    exit(1);
}

echo "✅ Konfigurasi dasar sudah benar\n";

echo "\n📧 Mengirim Email Test...\n";

try {
    // Try to send test email
    $testEmail = env('MAIL_FROM_ADDRESS');
    
    Mail::raw('Test email dari Desa Management. Jika Anda menerima ini, konfigurasi email berhasil! ✅', function ($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('Test Email - Desa Management');
    });
    
    echo "✅ Email terkirim ke: $testEmail\n";
    echo "📬 Periksa inbox Anda untuk memastikan email diterima.\n";
    
} catch (\Swift_TransportException $e) {
    echo "\n❌ Error: Gagal mengirim email\n";
    echo "─ " . $e->getMessage() . "\n\n";
    
    echo "🔧 Solusi:\n";
    echo "1. Pastikan menggunakan App Password (16 karakter), bukan password Gmail biasa\n";
    echo "2. Aktifkan 2-Step Verification di Google Account\n";
    echo "3. Aktifkan IMAP di Gmail Settings\n";
    echo "4. Lihat SETUP_EMAIL_GMAIL.md untuk instruksi detail\n";
    exit(1);
    
} catch (\Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n✨ Email configuration berhasil!\n";

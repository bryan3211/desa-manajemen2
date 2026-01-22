<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicAgendaController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/contact-us', [ContactController::class, 'show'])->name('contact');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::get('/debug-avatar', fn() => view('debug-avatar'))->middleware('auth');

// ============================================
// PUBLIC AGENDA ROUTES (Tanpa Login)
// ============================================
Route::get('/agendas', [PublicAgendaController::class, 'index'])->name('public.agenda.index');
Route::get('/agendas/{agenda}', [PublicAgendaController::class, 'show'])->name('public.agenda.show');

// ============================================
// API ROUTES (Authenticated)
// ============================================
Route::middleware(['auth', 'web'])->prefix('api')->group(function () {
    // Mark notification as read
    Route::post('/notifications/{id}/read', function ($id) {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    });

    // Pengguna: Dapatkan pembaruan terkini
    Route::get('/user/recent-updates', [DashboardController::class, 'getRecentUpdates'])
        ->middleware('cekRole:user')
        ->name('api.user.recent-updates');

    // Admin: Dapatkan pembaruan terkini
    Route::get('/admin/recent-updates', [DashboardController::class, 'getAdminRecentUpdates'])
        ->middleware('cekRole:admin')
        ->name('api.admin.recent-updates');
});

// ============================================
// PUBLIC API ROUTES (Guest)
// ============================================
Route::prefix('api')->group(function () {
    // Dapatkan statistik real-time
    Route::get('/statistics', [DashboardController::class, 'getStatistics'])
        ->name('api.statistics');

    // Track visitor manually
    Route::post('/track-visitor', function (Request $request) {
        try {
            \DB::table('visitors')->insert([
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'action' => $request->input('action', 'view'),
                'page' => $request->input('page', 'welcome'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    })->name('api.track-visitor');
});

// ============================================
// PUBLIC VERIFICATION ROUTES (No Authentication Required)
// ============================================
Route::get('/surat/verify', [\App\Http\Controllers\SuratController::class, 'verifySignature'])->name('surat.verify');
Route::get('/pengajuan/ttd', [\App\Http\Controllers\SuratController::class, 'verifyQrCode'])->name('pengajuan.ttd');

// ============================================
// GUEST ROUTES (Belum Login)
// ============================================
Route::middleware(['guest'])->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Register
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // Verifikasi Email
    Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
    Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp');

    // Login SSO Google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('sso.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('sso.google.callback');

    // Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showRequestForm'])->name('forgot_password.email_form');
    // Kirim OTP untuk reset password
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link');
    // Password reset - verify OTP first
    Route::get('/password-reset/verify', [AuthController::class, 'showVerifyResetForm'])->name('password.verify.form');
    Route::post('/password-reset/verify', [AuthController::class, 'verifyResetOtp'])->name('password.verify');
    // Formulir reset password (dapat diakses hanya setelah verifikasi OTP)
    Route::get('/password-reset', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ============================================
// AUTHENTICATED ROUTES (Sudah Login)
// ============================================
Route::middleware(['auth', 'web'])->group(function () {
    // Notifications
    Route::get('/notifications/{id}', function ($id) {
        $notification = \App\Models\Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$notification) {
            abort(404);
        }
        
        // Mark as read
        if (!$notification->is_read) {
            $notification->markAsRead();
        }
        
        return view('notifications.show', compact('notification'));
    })->name('notifications.show');

    // Dashboard & Logout
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // My Profile & Verifikasi Email
    Route::get('/myprofile', function () {
        $user = Auth::user();
        $biodata = $user->biodata;
        
        return view('myprofile', compact('user', 'biodata'));
    })->name('myprofile');

    // Profile Security & Password
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::post('/profile/update-security', [ProfileController::class, 'updateSecurity'])->name('profile.update.security');
    Route::post('/profile/update-biodata', [ProfileController::class, 'updateBiodata'])->name('profile.update.biodata');
    Route::get('/profile/security-info', [ProfileController::class, 'getSecurityInfo'])->name('profile.security.info');

    // Verifikasi Email untuk user yang sudah login
    Route::get('/verify-email-dashboard', [AuthController::class, 'showVerifyFormAuth'])->name('verify.form.auth');
    Route::post('/send-otp-auth', [AuthController::class, 'sendOtp'])->name('send.otp.auth');
    Route::post('/verify-email-auth', [AuthController::class, 'verify'])->name('verify.otp.auth');

    // ============================================
    // ADMIN ROUTES
    // ============================================
    Route::middleware(['cekRole:admin'])->group(function () {
        Route::get('/verifikasi', fn() => view('admin.verifikasi'))->name('admin.verifikasi');

        // Tampilan cetak untuk surat (Admin)
        Route::get('/admin/surat/{id}/print', [SuratController::class, 'printView'])->name('admin.surat.print');
        // Preview with edited body (opens printable view with temporary content)
        Route::post('/admin/surat/{id}/preview', [SuratController::class, 'preview'])->name('admin.surat.preview');
        // Save edited body into surat
        Route::post('/admin/surat/{id}/save-body', [SuratController::class, 'saveBody'])->name('admin.surat.save_body');
        Route::get('/admin/surat/export-all', [SuratController::class, 'exportAllPdf'])->name('admin.surat.export_all');

        // Tautan verifikasi publik untuk QR tanda tangan digital
        // Route::get('/surat/verify', [\App\Http\Controllers\SuratController::class, 'verifySignature'])->name('surat.verify');
        // QR Code verification endpoint (similar to external system format)
        // Route::get('/pengajuan/ttd', [\App\Http\Controllers\SuratController::class, 'verifyQrCode'])->name('pengajuan.ttd');
        // Save edited body into surat
        Route::post('/admin/surat/{id}/save-body', [SuratController::class, 'saveBody'])->name('admin.surat.save_body');
        Route::get('/admin/surat/export-all', [SuratController::class, 'exportAllPdf'])->name('admin.surat.export_all');
        Route::resource('/admin/agendas', AgendaController::class, ['names' => 'admin.agenda']);
        Route::post('/admin/agendas/{agenda}/toggle-publish', [AgendaController::class, 'togglePublish'])->name('admin.agenda.togglePublish');
        Route::post('/admin/agendas/{agenda}/upload-documentation', [AgendaController::class, 'uploadDocumentation'])->name('admin.agenda.uploadDocumentation');
        Route::delete('/admin/agenda-documentations/{documentation}', [AgendaController::class, 'deleteDocumentation'])->name('admin.agenda.deleteDocumentation');
        
        // Biodata Admin
        Route::get('/admin/biodata', [BiodataController::class, 'adminIndex'])->name('admin.biodata.index');
        Route::get('/admin/biodata/create', [BiodataController::class, 'adminCreate'])->name('admin.biodata.create');
        Route::post('/admin/biodata', [BiodataController::class, 'adminStore'])->name('admin.biodata.store');
        Route::get('/admin/biodata/{id}', [BiodataController::class, 'adminShow'])->name('admin.biodata.show');
        Route::get('/admin/biodata/{id}/edit', [BiodataController::class, 'adminEdit'])->name('admin.biodata.edit');
        Route::put('/admin/biodata/{id}', [BiodataController::class, 'adminUpdate'])->name('admin.biodata.update');
        Route::delete('/admin/biodata/{id}', [BiodataController::class, 'adminDestroy'])->name('admin.biodata.destroy');
        Route::put('/admin/biodata/{id}/verify', [BiodataController::class, 'adminVerify'])->name('admin.biodata.verify');
        
        // Pengaduan Admin
        Route::get('/admin/pengaduan', [PengaduanController::class, 'adminIndex'])->name('admin.pengaduan.index');
        Route::get('/admin/pengaduan/filter', [PengaduanController::class, 'adminFilter'])->name('admin.pengaduan.filter');
        Route::get('/admin/pengaduan/{id}', [PengaduanController::class, 'adminShow'])->name('admin.pengaduan.show');
        Route::put('/admin/pengaduan/{id}', [PengaduanController::class, 'adminUpdate'])->name('admin.pengaduan.update');
        Route::delete('/admin/pengaduan/{id}', [PengaduanController::class, 'adminDestroy'])->name('admin.pengaduan.destroy');
        Route::delete('/admin/pengaduan/{id}', [PengaduanController::class, 'adminDestroy'])->name('admin.pengaduan.destroy');

        // Surat Admin
        Route::get('/admin/surat', [\App\Http\Controllers\SuratController::class, 'adminIndex'])->name('admin.surat.index');
        Route::get('/admin/surat/{id}', [\App\Http\Controllers\SuratController::class, 'adminShow'])->name('admin.surat.show');
        Route::put('/admin/surat/{id}/verify', [\App\Http\Controllers\SuratController::class, 'adminVerify'])->name('admin.surat.verify');
        Route::delete('/admin/surat/{id}', [\App\Http\Controllers\SuratController::class, 'adminDestroy'])->name('admin.surat.destroy');
        
        // Tracking Admin
        Route::post('/admin/tracking/surat/{id}/status', [TrackingController::class, 'updateSuratStatus'])->name('admin.tracking.surat.update');
        Route::post('/admin/tracking/pengaduan/{id}/status', [TrackingController::class, 'updatePengaduanStatus'])->name('admin.tracking.pengaduan.update');

        // Activity Logs Admin
        Route::get('/admin/activity-logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('/admin/activity-logs/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'show'])->name('admin.activity-logs.show');
        Route::delete('/admin/activity-logs/{activityLog}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('admin.activity-logs.destroy');

        // Export PDF Admin - fitur dihapus
        // (Routes removed as per request)
    });

    // ============================================
    // USER ROUTES
    // ============================================
    Route::middleware(['cekRole:user'])->group(function () {
        // Agenda User
        Route::get('/agenda', [PublicAgendaController::class, 'index'])->name('user.agenda.index');
        Route::get('/agenda/{agenda}', [PublicAgendaController::class, 'show'])->name('user.agenda.show');
        
        // Biodata User
        Route::get('/biodata', [BiodataController::class, 'index'])->name('user.biodata.index');
        Route::get('/biodata/show', [BiodataController::class, 'show'])->name('user.biodata.show');
        Route::post('/biodata', [BiodataController::class, 'store'])->name('user.biodata.store');
        Route::put('/biodata', [BiodataController::class, 'update'])->name('user.biodata.update');
        
        // Tracking
        Route::get('/tracking', [TrackingController::class, 'index'])->name('user.tracking.index');
        Route::get('/tracking/surat/{id}', [TrackingController::class, 'showSurat'])->name('user.tracking.surat');
        Route::get('/tracking/pengaduan/{id}', [TrackingController::class, 'showPengaduan'])->name('user.tracking.pengaduan');
        Route::get('/api/tracking/{type}/{id}', [TrackingController::class, 'getTrackingTimeline'])->name('api.tracking.timeline');
        
        // Surat User
        Route::get('/surat', [\App\Http\Controllers\SuratController::class, 'index'])->name('user.surat.index');
        Route::get('/surat/create', [\App\Http\Controllers\SuratController::class, 'create'])->name('user.surat.create');
        Route::get('/surat/create/{type}', [\App\Http\Controllers\SuratController::class, 'create'])->name('user.surat.create.type');
        Route::post('/surat', [\App\Http\Controllers\SuratController::class, 'store'])->name('user.surat.store');
        Route::get('/surat/{id}', [\App\Http\Controllers\SuratController::class, 'show'])->name('user.surat.show');
        Route::get('/surat/{id}/edit', [\App\Http\Controllers\SuratController::class, 'edit'])->name('user.surat.edit');
        Route::put('/surat/{id}', [\App\Http\Controllers\SuratController::class, 'update'])->name('user.surat.update');
        Route::delete('/surat/{id}', [\App\Http\Controllers\SuratController::class, 'destroy'])->name('user.surat.destroy');
        Route::get('/surat/{id}/print', [\App\Http\Controllers\SuratController::class, 'userPrintView'])->name('user.surat.print');

        // Pengaduan User
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('user.pengaduan.index');
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('user.pengaduan.create');
        Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('user.pengaduan.store');
        Route::get('/pengaduan/{id}', [PengaduanController::class, 'show'])->name('user.pengaduan.show');
        Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('user.pengaduan.destroy');

        // Ulasan User
        Route::get('/ulasan', [ReviewController::class, 'index'])->name('user.ulasan.index');
        Route::get('/ulasan/create', [ReviewController::class, 'create'])->name('user.ulasan.create');
        Route::post('/ulasan', [ReviewController::class, 'store'])->name('user.ulasan.store');
        Route::get('/ulasan/{id}/edit', [ReviewController::class, 'edit'])->name('user.ulasan.edit');
        Route::put('/ulasan/{id}', [ReviewController::class, 'update'])->name('user.ulasan.update');
        Route::delete('/ulasan/{id}', [ReviewController::class, 'destroy'])->name('user.ulasan.destroy');
    });
});
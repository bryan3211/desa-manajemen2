<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Biodata;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Mail\ResetPasswordMail;
use App\Mail\SendOtpMail;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi menggunakan NIK
        $request->validate([
            'nik' => 'required|digits:16',
            'password' => 'required|min:6',
        ], [
            'nik.required' => 'NIK harus diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        $remember = $request->has('remember');
        
        // Normalize input: trim whitespace
        $credential = trim($request->nik);

        // If the credential has non-digit characters, but user entered spaces or formatting, remove non-digits for NIK check
        $normalizedNik = preg_replace('/[^0-9]/', '', $credential);

        // First try to find user by NIK (normalized to digits)
        $user = User::where('nik', $normalizedNik)->first();

        // If not found and the input looks like an email, try by email as a fallback
        $triedEmailFallback = false;
        if (!$user && filter_var($credential, FILTER_VALIDATE_EMAIL)) {
            $triedEmailFallback = true;
            $user = User::where('email', $credential)->first();
        }

        if (!$user) {
            return back()->withErrors([
                'nik' => 'NIK tidak terdaftar dalam sistem.',
            ])->withInput($request->only('nik'));
        }

        // Prepare credentials array for Auth::attempt depending on what we matched
        $attemptCredentials = [];
        if ($triedEmailFallback) {
            $attemptCredentials = ['email' => $credential, 'password' => $request->password];
        } else {
            $attemptCredentials = ['nik' => $normalizedNik, 'password' => $request->password];
        }

        if (Auth::attempt($attemptCredentials, $remember)) {
            $request->session()->regenerate();
            
            // Log successful login
            ActivityLog::log(
                'login',
                'User logged in successfully',
                Auth::id(),
                null,
                null,
                ['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'nik' => ($triedEmailFallback ? 'Email atau password yang Anda masukkan salah.' : 'NIK atau password yang Anda masukkan salah.'),
        ])->withInput($request->only('nik'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Basic debug log to confirm controller is called (do not log passwords)
        Log::info('AuthController@register called', ['email' => $request->email ?? null, 'nik' => $request->nik ?? null, 'ip' => $request->ip()]);

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|digits:16|unique:users,nik',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'nik.required' => 'NIK harus diisi',
            'nik.digits' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'name.required' => 'Nama lengkap harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Validasi field biodata tambahan (optional)
        $request->validate([
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:15',
            'alamat_lengkap' => 'nullable|string|max:500',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:100',
            'kecamatan' => 'nullable|string|max:100',
            'kabupaten_kota' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            // Buat user
            $user = User::create([
                'name' => $request->name,
                'nik' => $request->nik,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role ?? 'user',
            ]);

            // Otomatis buat biodata dengan NIK dan nama dari registrasi
            Biodata::create([
                'user_id' => $user->id,
                'nik' => $request->nik,
                'nama_lengkap' => $request->name,
                'email' => $request->email,
                'status_verifikasi' => 'terverifikasi',
                'kewarganegaraan' => 'WNI',
            ]);

            // Update biodata dengan field tambahan jika ada
            $user->biodata()->update([
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'agama' => $request->agama,
                'status_perkawinan' => $request->status_perkawinan,
                'pekerjaan' => $request->pekerjaan,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'kabupaten_kota' => $request->kabupaten_kota,
                'provinsi' => $request->provinsi,
                'kode_pos' => $request->kode_pos,
                'nama_ayah' => $request->nama_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nama_ibu' => $request->nama_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
            ]);

            DB::commit();

            $request->session()->flash('registered_nik', $request->nik);
            $request->session()->flash('registered_email', $request->email);

            return redirect()->route('login')
                ->with('success', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Registration Error: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])
                        ->withInput();
        }
    }

    public function sendOtp(Request $request)
    {
        $user = null;
        
        // Jika user sudah login
        if (Auth::check()) {
            $user = Auth::user();
        } 
        // Jika dari registrasi/belum login
        elseif (session('verify_email')) {
            $user = User::where('email', session('verify_email'))->firstOrFail();
        } 
        // Jika dari request API
        elseif ($request->email) {
            $user = User::where('email', $request->email)->firstOrFail();
        }
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

        $setResendOtp = 60;

        if (session('last_otp_sent') && abs((int)now()->diffInSeconds(session('last_otp_sent'))) < $setResendOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Tunggu ' . $setResendOtp . ' detik sebelum mengirim ulang OTP.'
            ], 429);
        }

        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->addMinutes(5);
        $user->save();

        $subject = 'OTP Verifikasi Email';
        Mail::to($user->email)->send(new SendOtpMail(
            $subject,
            $user->name,
            $otp,
            $user->otp_expires_at->format('d M Y H:i:s')
        ));

        session([
            'verify_email' => $user->email,
            'last_otp_sent' => now(),
        ]);

        // Jika request dari AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kode OTP telah dikirim ke ' . $user->email
            ]);
        }
        
        return redirect()->route('verify.form')->with('success', 'Kode OTP telah dikirim ke ' . $user->email);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = null;
        
        // Jika user sudah login
        if (Auth::check()) {
            $user = Auth::user();
        } 
        // Jika dari registrasi/belum login
        elseif (session('verify_email')) {
            $user = User::where('email', session('verify_email'))->first();
        }

        if (!$user) {
            $msg = 'Data verifikasi tidak ditemukan.';
            Log::warning('Verify attempted but user not found', ['session_email' => session('verify_email'), 'ip' => $request->ip()]);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg
                ], 404);
            }
            return redirect()->route('login')->withErrors(['email' => $msg]);
        }

        $otpInput = trim((string) $request->otp);
        Log::info('Verify attempt', ['user_id' => $user->id, 'email' => $user->email]);

        if (!Hash::check($otpInput, $user->otp_code)) {
            Log::warning('OTP mismatch', ['user_id' => $user->id]);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP salah.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }
        
        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            Log::warning('OTP expired', ['user_id' => $user->id]);
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode OTP sudah kedaluwarsa.'
                ], 422);
            }
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa.']);
        }

        $user->is_verified = true;
        $user->email_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Jika biodata ada, tandai sebagai terverifikasi juga
        if ($user->biodata) {
            $user->biodata->status_verifikasi = 'terverifikasi';
            $user->biodata->save();
        }

        // Refresh user instance in session so UI reflects change immediately
        if (Auth::check() && Auth::id() === $user->id) {
            Auth::setUser($user->fresh());
        }

        session()->forget(['verify_email', 'last_otp_sent']);
        $request->session()->flash('registered_email', $user->email);

        Log::info('User email verified', ['user_id' => $user->id]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Email berhasil diverifikasi!'
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Email berhasil diverifikasi!')->with('verified', true);
    }

    public function showVerifyFormAuth(Request $request)
    {
        // For authenticated users to verify from dashboard
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // If already verified, redirect to dashboard
        if ($user->is_verified) {
            return redirect()->route('dashboard')->with('success', 'Email Anda sudah terverifikasi!');
        }

        // Send OTP using the existing sendOtp method
        $this->sendOtp($request);

        $cooldown = 0;
        $setResendOtp = 60;
        if (session('last_otp_sent')) {
            $diff = (int)now()->diffInSeconds(session('last_otp_sent'));
            $cooldown = abs($diff);
        }

        return view('auth.verify-email', [
            'cooldown' => $cooldown,
            'timeResendOtp' => $setResendOtp
        ]);
    }

    public function showVerifyForm()
    {
        if (!session('verify_email')) {
            return redirect()->route('login');
        }

        $cooldown = 0;
        $setResendOtp = 60;
        if (session('last_otp_sent')) {
            $diff = (int)now()->diffInSeconds(session('last_otp_sent'));
            $cooldown = abs($diff);
        }

        return view('auth.verify-email', [
            'cooldown' => $cooldown,
            'timeResendOtp' => $setResendOtp
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            Log::info('Google OAuth Callback Started');
            
            $googleUser = Socialite::driver('google')->user();
            Log::info('Google User Retrieved', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'id' => $googleUser->getId()
            ]);

            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'is_verified' => true,
                    'password' => Hash::make(Str::random(16))
                ]
            );

            Log::info('User Created/Updated', ['user_id' => $user->id]);

            Auth::login($user, true);

            // Jika user login via SSO dan belum punya biodata, arahkan ke pengisian biodata
            if ($user->provider && !$user->biodata) {
                return redirect()->route('user.biodata.index')->with('info', 'Selamat datang! Silakan lengkapi biodata Anda terlebih dahulu.');
            }

            return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
        } catch (\Exception $e) {
            Log::error('Google OAuth Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')->withErrors('Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    public function showRequestForm()
    {
        return view('auth.forgot-password.email');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem kami']);
        }

        // Generate 6-digit OTP for password reset
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->otp_code = bcrypt($otp);
        $user->otp_expires_at = now()->addMinutes(10);
        $user->save();

        // Send OTP mail
        $subject = 'OTP Reset Password';
        Mail::to($user->email)->send(new SendOtpMail(
            $subject,
            $user->name,
            $otp,
            $user->otp_expires_at->format('d M Y H:i:s')
        ));

        // Store email in session to identify request
        session(['password_reset_email' => $user->email, 'last_password_otp_sent' => now()]);

        Log::info('Password reset OTP sent', ['email' => $user->email, 'expires_at' => $user->otp_expires_at]);

        // Redirect to OTP verification form first
        return redirect()->route('password.verify.form')->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan masukkan OTP untuk melanjutkan.');
    }

    public function showVerifyResetForm()
    {
        if (!session('password_reset_email')) {
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Silakan masukkan email terlebih dahulu untuk menerima OTP.']);
        }

        $cooldown = 0;
        $setResendOtp = 60;
        if (session('last_password_otp_sent')) {
            $diff = (int)now()->diffInSeconds(session('last_password_otp_sent'));
            $cooldown = abs($diff);
        }

        $email = session('password_reset_email');

        return view('auth.forgot-password.verify', compact('cooldown', 'setResendOtp', 'email'));
    }

    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $email = session('password_reset_email') ?? $request->email;
        $user = $email ? User::whereEmail($email)->first() : null;

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Email untuk reset tidak ditemukan.'], 404);
            }
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Email untuk reset tidak ditemukan.']);
        }

        if (!$user->otp_code || !$user->otp_expires_at) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Tidak ada permintaan reset aktif. Silakan request ulang.'], 422);
            }
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Tidak ada permintaan reset aktif. Silakan request ulang.']);
        }

        if (now()->gt($user->otp_expires_at)) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode OTP sudah kadaluarsa.'], 422);
            }
            return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa.']);
        }

        if (!Hash::check($request->otp, $user->otp_code)) {
            Log::warning('Invalid password reset OTP attempt', ['email' => $user->email]);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid.'], 422);
            }
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        // OTP valid: allow access to reset form and clear otp so it can't be reused
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        session(['password_reset_allowed' => true]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'OTP valid. Silakan buat password baru.']);
        }

        return redirect()->route('password.reset')->with('success', 'OTP valid. Silakan buat password baru.');
    }

    public function showResetForm(Request $request)
    {
        $email = session('password_reset_email') ?? $request->query('email');
        $user = $email ? User::whereEmail($email)->first() : null;

        // Require OTP verification first
        if (!session('password_reset_allowed')) {
            return redirect()->route('password.verify.form')->withErrors(['otp' => 'Harap verifikasi kode OTP terlebih dahulu.']);
        }

        return view('auth.forgot-password.reset', compact('user', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Ensure the user had verified their OTP
        if (!session('password_reset_allowed') || !session('password_reset_email')) {
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Proses reset tidak diizinkan. Silakan request ulang OTP.']);
        }

        if ($request->email !== session('password_reset_email')) {
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Email tidak sesuai dengan permintaan reset.']);
        }

        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return redirect()->route('forgot_password.email_form')->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Log::info('Password successfully reset', ['email' => $user->email]);

        // Clear session flags
        session()->forget(['password_reset_email', 'password_reset_allowed', 'last_password_otp_sent']);

        return redirect('/login')->with('success', 'Password berhasil direset! Silakan login menggunakan password baru Anda.');
    }

    public function logout(Request $request)
    {
        // Log logout before destroying session
        if (Auth::check()) {
            ActivityLog::log(
                'logout',
                'User logged out',
                Auth::id(),
                null,
                null,
                ['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
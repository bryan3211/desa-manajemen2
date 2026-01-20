<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    /**
     * Show biodata form or display if exists
     */
    public function index()
    {
        $biodata = Biodata::where('user_id', Auth::id())->first();

        if (!$biodata) {
            // Jika user login via SSO (provider ada), izinkan mereka membuat biodata sendiri
            if (Auth::user()->provider) {
                return view('user.biodata.create', ['biodata' => null]);
            }
            // Users are view-only in this app. If biodata is missing, instruct user to contact admin.
            return redirect()->route('dashboard')
                ->with('info', 'Biodata Anda belum tersedia. Silakan hubungi admin untuk menambahkan biodata.');
        }

        // Cek apakah biodata sudah terverifikasi (dari registrasi lengkap)
        if ($biodata->status_verifikasi === 'terverifikasi') {
            return view('user.biodata.show', compact('biodata'));
        }

        // Jika belum terverifikasi, cek apakah biodata masih minimal
        if (!$biodata->tanggal_lahir || !$biodata->alamat_lengkap) {
            return view('user.biodata.create', compact('biodata'));
        }

        return view('user.biodata.show', compact('biodata'));
    }

    /**
     * Show biodata for authenticated user (explicit route)
     */
    public function show()
    {
        $biodata = Biodata::where('user_id', Auth::id())->first();
        if (!$biodata) {
            return redirect()->route('dashboard')
                ->with('info', 'Biodata Anda belum tersedia. Silakan hubungi admin untuk menambahkan biodata.');
        }
        return view('user.biodata.show', compact('biodata'));
    }

    /**
     * Show the form for creating biodata
     */
    public function create()
    {
        // Jika user login via SSO, izinkan mereka membuat biodata
        if (Auth::user()->provider) {
            $biodata = Biodata::where('user_id', Auth::id())->first();
            return view('user.biodata.create', compact('biodata'));
        }
        // Creation of biodata by normal users is disabled. Direct users to contact admin.
        return redirect()->route('dashboard')
            ->with('info', 'Pembuatan/mengedit biodata oleh pengguna dinonaktifkan. Silakan hubungi admin.');
    }

    /**
     * Store newly created biodata
     */
    public function store(Request $request)
    {
        // Hanya user SSO yang bisa store biodata baru
        if (!Auth::user()->provider) {
            return redirect()->route('dashboard')
                ->with('info', 'Pembuatan biodata oleh pengguna dinonaktifkan. Silakan hubungi admin.');
        }

        // Cek jika sudah ada biodata
        if (Biodata::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.biodata.show')
                ->with('info', 'Biodata sudah ada. Gunakan fitur update untuk mengedit.');
        }

        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:biodata,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'foto_ktp' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|max:2048',
            'foto_diri' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status_verifikasi'] = 'belum_verifikasi'; // Status awal untuk user SSO

        // Handle file uploads
        foreach (['foto_ktp', 'foto_kk', 'foto_diri'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $fileName = time() . '_' . $fileField . '_' . $file->getClientOriginalName();
                $file->storeAs('biodata', $fileName, 'public');
                $validated[$fileField] = $fileName;
            }
        }

        // Normalize jenis_kelamin
        if (array_key_exists('jenis_kelamin', $validated)) {
            $jk = strtolower(trim($validated['jenis_kelamin'] ?? ''));
            if (in_array($jk, ['laki-laki', 'laki laki', 'laki', 'l', 'male'])) {
                $validated['jenis_kelamin'] = 'L';
            } elseif (in_array($jk, ['perempuan', 'p', 'female'])) {
                $validated['jenis_kelamin'] = 'P';
            } else {
                $validated['jenis_kelamin'] = null;
            }
        }

        // Normalize agama
        if (array_key_exists('agama', $validated) && $validated['agama'] !== null) {
            $ag = ucfirst(strtolower(trim($validated['agama'])));
            $allowedAgama = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];
            $validated['agama'] = in_array($ag, $allowedAgama) ? $ag : null;
        }

        // Normalize status_perkawinan
        if (array_key_exists('status_perkawinan', $validated)) {
            $sp = strtolower(trim($validated['status_perkawinan'] ?? ''));
            $mapSp = [
                'belum kawin' => 'Belum Kawin', 'belum_verifikasi' => 'Belum Kawin', 'belum_kawin' => 'Belum Kawin',
                'kawin' => 'Kawin', 'nikah' => 'Kawin',
                'cerai hidup' => 'Cerai Hidup', 'cerai_hidup' => 'Cerai Hidup',
                'cerai mati' => 'Cerai Mati', 'cerai_mati' => 'Cerai Mati'
            ];
            $validated['status_perkawinan'] = $mapSp[$sp] ?? (strlen($validated['status_perkawinan']) ? $validated['status_perkawinan'] : null);
        }

        // Normalize pendidikan_terakhir
        if (array_key_exists('pendidikan_terakhir', $validated)) {
            $pt = strtoupper(trim($validated['pendidikan_terakhir'] ?? ''));
            $allowedPt = ['SD','SMP','SMA','D3','S1','S2','S3'];
            $validated['pendidikan_terakhir'] = in_array($pt, $allowedPt) ? $pt : null;
        }

        Biodata::create($validated);

        return redirect()->route('user.biodata.show')->with('success', 'Biodata berhasil dibuat.');
    }

    /**
     * Show the form for editing biodata
     */
    public function edit()
    {
        // Editing by regular users is disabled; instruct them to contact admin.
        return redirect()->route('dashboard')
            ->with('info', 'Pengeditan biodata oleh pengguna dinonaktifkan. Silakan hubungi admin.');
    }

    /**
     * Update the biodata for authenticated user
     */
    public function update(Request $request)
    {
        $biodata = Biodata::where('user_id', Auth::id())->firstOrFail();

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'foto_ktp' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|max:2048',
            'foto_diri' => 'nullable|image|max:2048',
        ];

        // Untuk user SSO, nik wajib diisi
        if (Auth::user()->provider) {
            $rules['nik'] = 'required|digits:16|unique:biodata,nik,' . $biodata->id;
        } else {
            $rules['nik'] = 'nullable|digits:16|unique:biodata,nik,' . $biodata->id;
        }

        $validated = $request->validate($rules);

        // Handle file uploads
        foreach (['foto_ktp', 'foto_kk', 'foto_diri'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($biodata->$fileField) {
                    Storage::disk('public')->delete('biodata/' . $biodata->$fileField);
                }
                $file = $request->file($fileField);
                $fileName = time() . '_' . $fileField . '_' . $file->getClientOriginalName();
                $file->storeAs('biodata', $fileName, 'public');
                $validated[$fileField] = $fileName;
            }
        }

        // Normalize jenis_kelamin
        if (array_key_exists('jenis_kelamin', $validated)) {
            $jk = strtolower(trim($validated['jenis_kelamin'] ?? ''));
            if (in_array($jk, ['laki-laki', 'laki laki', 'laki', 'l', 'male'])) {
                $validated['jenis_kelamin'] = 'L';
            } elseif (in_array($jk, ['perempuan', 'p', 'female'])) {
                $validated['jenis_kelamin'] = 'P';
            } else {
                $validated['jenis_kelamin'] = null;
            }
        }

        // Normalize agama
        if (array_key_exists('agama', $validated) && $validated['agama'] !== null) {
            $ag = ucfirst(strtolower(trim($validated['agama'])));
            $allowedAgama = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];
            $validated['agama'] = in_array($ag, $allowedAgama) ? $ag : null;
        }

        // Normalize status_perkawinan
        if (array_key_exists('status_perkawinan', $validated)) {
            $sp = strtolower(trim($validated['status_perkawinan'] ?? ''));
            $mapSp = [
                'belum kawin' => 'Belum Kawin', 'belum_verifikasi' => 'Belum Kawin', 'belum_kawin' => 'Belum Kawin',
                'kawin' => 'Kawin', 'nikah' => 'Kawin',
                'cerai hidup' => 'Cerai Hidup', 'cerai_hidup' => 'Cerai Hidup',
                'cerai mati' => 'Cerai Mati', 'cerai_mati' => 'Cerai Mati'
            ];
            $validated['status_perkawinan'] = $mapSp[$sp] ?? (strlen($validated['status_perkawinan']) ? $validated['status_perkawinan'] : null);
        }

        // Normalize pendidikan_terakhir
        if (array_key_exists('pendidikan_terakhir', $validated)) {
            $pt = strtoupper(trim($validated['pendidikan_terakhir'] ?? ''));
            $allowedPt = ['SD','SMP','SMA','D3','S1','S2','S3'];
            $validated['pendidikan_terakhir'] = in_array($pt, $allowedPt) ? $pt : null;
        }

        $biodata->update($validated);

        // Create notification for admin
        Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Biodata Diperbarui',
            'message' => 'Pengguna ' . Auth::user()->name . ' telah memperbarui biodata mereka.',
            'type' => 'biodata',
            'related_id' => $biodata->id,
            'is_read' => false,
        ]);

        return redirect()->route('user.biodata.show')->with('success', 'Biodata berhasil diperbarui.');
    }

    // ========== ADMIN METHODS ==========

    /**
     * Display all biodata for admin
     */
    public function adminIndex(Request $request)
    {
        $query = Biodata::with('user');

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status_verifikasi', $request->status);
        }

        // Search by NIK or Name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        $biodata = $query->orderBy('created_at', 'desc')->paginate(15);

        $statistik = [
            'belum_verifikasi' => Biodata::where('status_verifikasi', 'belum_verifikasi')->count(),
            'sedang_diverifikasi' => Biodata::where('status_verifikasi', 'sedang_diverifikasi')->count(),
            'terverifikasi' => Biodata::where('status_verifikasi', 'terverifikasi')->count(),
            'ditolak' => Biodata::where('status_verifikasi', 'ditolak')->count(),
            'total' => Biodata::count(),
        ];

        return view('admin.biodata.index', compact('biodata', 'statistik'));
    }

    /**
     * Show detail biodata for admin
     */
    public function adminShow($id)
    {
        $biodata = Biodata::with(['user', 'verifiedBy'])->findOrFail($id);

        return view('admin.biodata.show', compact('biodata'));
    }

    /**
     * Show form to create biodata (admin)
     */
    public function adminCreate()
    {
        return view('admin.biodata.create');
    }

    /**
     * Store new biodata created by admin
     */
    public function adminStore(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|string|digits:16|unique:biodata,nik|unique:users,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat_lengkap' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email',
            'status_verifikasi' => 'nullable|in:belum_verifikasi,sedang_diverifikasi,terverifikasi,ditolak',
        ], [
            'nik.unique' => 'NIK sudah terdaftar di sistem.',
            'email.unique' => 'Email sudah terdaftar di sistem.',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // Cari atau buat user baru
            $user = \App\Models\User::where('nik', $validated['nik'])->first();
            
            if (!$user) {
                // Jika user belum ada, buat user baru
                $user = \App\Models\User::create([
                    'name' => $validated['nama_lengkap'],
                    'nik' => $validated['nik'],
                    'email' => $validated['email'] ?? 'user_' . $validated['nik'] . '@desa.local',
                    'password' => bcrypt('password123'), // Default password
                    'role' => 'user',
                    'is_verified' => true, // Admin-created user is auto-verified
                ]);
            }

            $validated['user_id'] = $user->id;
            $validated['status_verifikasi'] = $validated['status_verifikasi'] ?? 'belum_verifikasi';

            Biodata::create($validated);

            \Illuminate\Support\Facades\DB::commit();

            return redirect()->route('admin.biodata.index')->with('success', 'Biodata dan user berhasil dibuat oleh admin.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Create Biodata Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat biodata: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show form to edit biodata (admin)
     */
    public function adminEdit($id)
    {
        $biodata = Biodata::with('user')->findOrFail($id);
        return view('admin.biodata.edit', compact('biodata'));
    }

    /**
     * Update biodata by admin
     */
    public function adminUpdate(Request $request, $id)
    {
        $biodata = Biodata::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'status_perkawinan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'kewarganegaraan' => 'nullable|string|max:50',
            'alamat_lengkap' => 'nullable|string',
            'rt' => 'nullable|string|max:10',
            'rw' => 'nullable|string|max:10',
            'desa_kelurahan' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten_kota' => 'nullable|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:255',
            'status_verifikasi' => 'nullable|in:belum_verifikasi,sedang_diverifikasi,terverifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
            'foto_ktp' => 'nullable|image|max:2048',
            'foto_kk' => 'nullable|image|max:2048',
            'foto_diri' => 'nullable|image|max:2048',
        ]);

        // Handle file uploads if admin wants to update documents
        foreach (['foto_ktp', 'foto_kk', 'foto_diri'] as $fileField) {
            if ($request->hasFile($fileField)) {
                if ($biodata->$fileField) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete('biodata/' . $biodata->$fileField);
                }
                $file = $request->file($fileField);
                $fileName = time() . '_' . $fileField . '_' . $file->getClientOriginalName();
                $file->storeAs('biodata', $fileName, 'public');
                $validated[$fileField] = $fileName;
            }
        }

        // If admin marks as verified, set verified_by and verified_at
        if (!empty($validated['status_verifikasi']) && $validated['status_verifikasi'] == 'terverifikasi') {
            $validated['verified_by'] = Auth::id();
            $validated['verified_at'] = now();
        }

        // Normalize/mapping for enum columns to avoid MySQL enum truncation warnings
        // jenis_kelamin in DB is enum('L','P')
        if (array_key_exists('jenis_kelamin', $validated)) {
            $jk = strtolower(trim($validated['jenis_kelamin'] ?? ''));
            if (in_array($jk, ['laki-laki', 'laki laki', 'laki', 'l', 'male'])) {
                $validated['jenis_kelamin'] = 'L';
            } elseif (in_array($jk, ['perempuan', 'p', 'female'])) {
                $validated['jenis_kelamin'] = 'P';
            } else {
                $validated['jenis_kelamin'] = null;
            }
        }

        // agama enum values are capitalized in DB
        if (array_key_exists('agama', $validated) && $validated['agama'] !== null) {
            $ag = ucfirst(strtolower(trim($validated['agama'])));
            $allowedAgama = ['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'];
            $validated['agama'] = in_array($ag, $allowedAgama) ? $ag : null;
        }

        // status_perkawinan mapping
        if (array_key_exists('status_perkawinan', $validated)) {
            $sp = strtolower(trim($validated['status_perkawinan'] ?? ''));
            $mapSp = [
                'belum kawin' => 'Belum Kawin', 'belum_verifikasi' => 'Belum Kawin', 'belum_kawin' => 'Belum Kawin',
                'kawin' => 'Kawin', 'nikah' => 'Kawin',
                'cerai hidup' => 'Cerai Hidup', 'cerai_hidup' => 'Cerai Hidup',
                'cerai mati' => 'Cerai Mati', 'cerai_mati' => 'Cerai Mati'
            ];
            $validated['status_perkawinan'] = $mapSp[$sp] ?? (strlen($validated['status_perkawinan']) ? $validated['status_perkawinan'] : null);
        }

        // pendidikan_terakhir mapping - allowed: SD,SMP,SMA,D3,S1,S2,S3
        if (array_key_exists('pendidikan_terakhir', $validated)) {
            $pt = strtoupper(trim($validated['pendidikan_terakhir'] ?? ''));
            $allowedPt = ['SD','SMP','SMA','D3','S1','S2','S3'];
            // If admin accidentally typed full words (e.g., 'sma' or 'SMA'), uppercase handles it.
            $validated['pendidikan_terakhir'] = in_array($pt, $allowedPt) ? $pt : null;
        }

        $biodata->update($validated);

        return redirect()->route('admin.biodata.show', $id)->with('success', 'Biodata berhasil diperbarui oleh admin.');
    }

    /**
     * Delete biodata by admin
     */
    public function adminDestroy($id)
    {
        $biodata = Biodata::findOrFail($id);

        // delete files
        foreach (['foto_ktp', 'foto_kk', 'foto_diri'] as $fileField) {
            if ($biodata->$fileField) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete('biodata/' . $biodata->$fileField);
            }
        }

        // Get user_id before deleting biodata
        $userId = $biodata->user_id;

        // Prevent deletion if the associated user is an admin
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->role === 'admin') {
                return redirect()->route('admin.biodata.show', $id)
                    ->with('error', 'NIK untuk akun admin tidak dapat dihapus.');
            }
        }

        // Delete biodata
        $biodata->delete();

        // Delete associated user (only non-admin users)
        if ($userId) {
            \App\Models\User::where('id', $userId)->delete();
        }

        return redirect()->route('admin.biodata.index')->with('success', 'Biodata dan user terkait berhasil dihapus.');
    }

    /**
     * Verify biodata
     */
    public function adminVerify(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:sedang_diverifikasi,terverifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $biodata = Biodata::findOrFail($id);

        $biodata->update([
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin' => $request->catatan_admin,
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        // Create notification for the user
        $notificationMessages = [
            'terverifikasi' => [
                'title' => '✅ Biodata Terverifikasi',
                'message' => 'Biodata Anda telah berhasil diverifikasi oleh admin. Anda sekarang dapat mengakses layanan yang lebih lengkap.',
                'type' => 'success',
            ],
            'ditolak' => [
                'title' => '❌ Biodata Ditolak',
                'message' => 'Biodata Anda ditolak oleh admin. Silakan periksa catatan admin dan hubungi untuk informasi lebih lanjut.',
                'type' => 'danger',
            ],
            'sedang_diverifikasi' => [
                'title' => '⏳ Biodata Sedang Diverifikasi',
                'message' => 'Biodata Anda sedang dalam proses verifikasi. Kami akan memberitahu Anda setelah selesai.',
                'type' => 'warning',
            ],
        ];

        if (isset($notificationMessages[$request->status_verifikasi])) {
            $notif = $notificationMessages[$request->status_verifikasi];
            Notification::create([
                'user_id' => $biodata->user_id,
                'title' => $notif['title'],
                'message' => $notif['message'],
                'type' => $notif['type'],
                'related_type' => 'biodata',
                'related_id' => $biodata->id,
            ]);
        }

        return redirect()->route('admin.biodata.show', $id)
            ->with('success', 'Status verifikasi berhasil diperbarui!');
    }
}
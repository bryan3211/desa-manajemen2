<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Biodata;

class ProfileController extends Controller
{
    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',           // lowercase
                'regex:/[A-Z]/',           // uppercase
                'regex:/[0-9]/',           // digit
                'regex:/[!@#$%^&*]/',      // special character
                'confirmed'
            ],
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.min' => 'Password minimal 8 karakter',
            'new_password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai'
            ], 401);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah. Silakan login kembali dengan password baru.'
        ]);
    }

    /**
     * Update security settings
     */
    public function updateSecurity(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $validator = Validator::make($request->all(), [
            'two_factor_enabled' => 'nullable|boolean',
            'password_changed_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update security settings
        $user->update([
            'two_factor_enabled' => $request->two_factor_enabled ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan keamanan berhasil diperbarui'
        ]);
    }

    /**
     * Get password last changed time
     */
    public function getSecurityInfo()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'data' => [
                'last_password_change' => $user->updated_at,
                'email_verified' => $user->is_verified,
                'email_verified_at' => $user->email_verified_at,
                'two_factor_enabled' => $user->two_factor_enabled ?? false,
            ]
        ]);
    }

    /**
     * Update user biodata
     */
    public function updateBiodata(Request $request)
    {
        $user = Auth::user();
        $biodata = $user->biodata;

        if (!$biodata) {
            return response()->json([
                'success' => false,
                'message' => 'Biodata tidak ditemukan'
            ], 404);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'required|string|max:50',
            'status_perkawinan' => 'required|string|max:50',
            'pekerjaan' => 'required|string|max:255',
            'kewarganegaraan' => 'nullable|string|max:100',
            'alamat_lengkap' => 'required|string|max:500',
            'rt' => 'required|string|max:10',
            'rw' => 'required|string|max:10',
            'desa_kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'provinsi' => 'nullable|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'nama_ayah' => 'nullable|string|max:255',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:100',
        ], [
            'nama_lengkap.required' => 'Nama lengkap harus diisi',
            'tempat_lahir.required' => 'Tempat lahir harus diisi',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'agama.required' => 'Agama harus diisi',
            'status_perkawinan.required' => 'Status perkawinan harus diisi',
            'pekerjaan.required' => 'Pekerjaan harus diisi',
            'alamat_lengkap.required' => 'Alamat lengkap harus diisi',
            'rt.required' => 'RT harus diisi',
            'rw.required' => 'RW harus diisi',
            'desa_kelurahan.required' => 'Desa/Kelurahan harus diisi',
            'kecamatan.required' => 'Kecamatan harus diisi',
            'kabupaten_kota.required' => 'Kabupaten/Kota harus diisi',
            'no_hp.required' => 'No. HP harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update biodata
        $biodata->update($request->only([
            'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama',
            'status_perkawinan', 'pekerjaan', 'kewarganegaraan', 'alamat_lengkap',
            'rt', 'rw', 'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi',
            'kode_pos', 'no_hp', 'email', 'nama_ayah', 'nama_ibu', 'pekerjaan_ayah',
            'pekerjaan_ibu', 'pendidikan_terakhir'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Biodata berhasil diperbarui'
        ]);
    }
}

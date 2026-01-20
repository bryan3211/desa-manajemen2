<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
}

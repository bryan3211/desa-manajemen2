<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckBiodata
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Hanya check untuk user yang login via SSO dan belum punya biodata lengkap
        if (Auth::check() && Auth::user()->provider) {
            $biodata = Auth::user()->biodata;

            // Jika tidak ada biodata atau biodata belum lengkap
            if (!$biodata || !$biodata->tanggal_lahir || !$biodata->alamat_lengkap) {
                // Izinkan akses ke halaman biodata dan logout
                if ($request->routeIs(['user.biodata.*', 'logout'])) {
                    return $next($request);
                }

                // Redirect ke biodata
                return redirect()->route('user.biodata.index')
                    ->with('warning', 'Silakan lengkapi biodata Anda terlebih dahulu sebelum mengakses fitur lainnya.');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Notification;
use App\Models\RequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\ActivityLog;

class SuratController extends Controller
{
    // USER: list submissions
    public function index()
    {
        $surats = Surat::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('user.surat.index', compact('surats'));
    }

    // Show create page or type-specific form
    public function create($type = null)
    {
        $biodata = \App\Models\Biodata::where('user_id', Auth::id())->first();

        if (!$type) {
            return view('user.surat.create', compact('biodata'));
        }

        $type = strtolower($type);
        $validTypes = ['ktp','sktm','domisili','izin_usaha','surat_kelahiran','surat_kematian','surat_pindah','surat_rekomendasi','kk_kia','akta_kelahiran','izin_imb','pembetulan_data'];
        if (!in_array($type, $validTypes)) {
            return redirect()->route('user.surat.create')->with('error', 'Jenis surat tidak dikenali');
        }

        return view('user.surat.form_' . $type, compact('type', 'biodata'));
    }

    // Store submission
    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat' => 'required|string',
            'attachment' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $biodata = \App\Models\Biodata::where('user_id', Auth::id())->first();

        $jenis = strtolower($request->jenis_surat);
        $data = [];

        // type-specific validation and data extraction
        if ($jenis == 'ktp') {
            $v = $request->validate([
                'tempat_lahir' => 'nullable|string',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string',
            ]);
            $data = $v;
            $data['nik'] = $biodata->nik ?? '';
            $data['nama_lengkap'] = $biodata->nama_lengkap ?? '';
        } elseif ($jenis == 'sktm') {
            $v = $request->validate([
                'tujuan' => 'required|string',
                'keterangan' => 'nullable|string',
                'jumlah_anggota_keluarga' => 'nullable|integer',
                'alamat' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'domisili') {
            $v = $request->validate([
                'alamat' => 'required|string',
                'keterangan' => 'nullable|string',
                'tujuan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'izin_usaha') {
            $v = $request->validate([
                'nama_usaha' => 'required|string',
                'jenis_usaha' => 'required|string',
                'alamat_usaha' => 'required|string',
                'modal_usaha' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_kelahiran') {
            $v = $request->validate([
                'nama_bayi' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'nama_ibu' => 'required|string',
                'nik_ibu' => 'nullable|digits:16',
                'nama_ayah' => 'required|string',
                'nik_ayah' => 'nullable|digits:16',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_kematian') {
            $v = $request->validate([
                'nama_almarhum' => 'required|string',
                'nik_almarhum' => 'nullable|digits:16',
                'tanggal_meninggal' => 'required|date',
                'tempat_meninggal' => 'required|string',
                'penyebab_kematian' => 'nullable|string',
                'usia' => 'nullable|integer',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_pindah') {
            $v = $request->validate([
                'alamat_asal' => 'required|string',
                'desa_tujuan' => 'required|string',
                'kecamatan_tujuan' => 'required|string',
                'alasan_pindah' => 'nullable|string',
                'jumlah_anggota_keluarga' => 'nullable|integer',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_rekomendasi') {
            $v = $request->validate([
                'tujuan' => 'required|string',
                'keperluan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'kk_kia') {
            $v = $request->validate([
                'jenis_dokumen' => 'required|in:KK,KIA',
                'nomor_kk' => 'nullable|string',
                'nik_kepala_keluarga' => 'nullable|digits:16',
                'tujuan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'akta_kelahiran') {
            $v = $request->validate([
                'nama_anak' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'nama_ibu' => 'required|string',
                'nik_ibu' => 'nullable|digits:16',
                'nama_ayah' => 'required|string',
                'nik_ayah' => 'nullable|digits:16',
                'hari_melapor' => 'required|date',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'izin_imb') {
            $v = $request->validate([
                'alamat_lahan' => 'required|string',
                'luas_tanah' => 'required|string',
                'jenis_bangunan' => 'required|string',
                'luas_bangunan' => 'required|string',
                'fungsi_bangunan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
            $data['nama_pemohon'] = $biodata->nama_lengkap ?? '';
            $data['nik_pemohon'] = $biodata->nik ?? '';
        } elseif ($jenis == 'pembetulan_data') {
            $v = $request->validate([
                'jenis_data' => 'required|string',
                'data_lama' => 'required|string',
                'data_baru' => 'required|string',
                'alasan_pembetulan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('surat', $fileName, 'public');
            $attachmentPath = $fileName;
        }

        $surat = Surat::create([
            'user_id' => Auth::id(),
            'jenis_surat' => $jenis,
            'data' => $data,
            'attachment' => $attachmentPath,
            'status_verifikasi' => 'pending',
        ]);

        // Log surat creation
        ActivityLog::log(
            'create',
            'Created a new surat application',
            Auth::id(),
            $surat,
            null,
            ['jenis_surat' => $this->getNamaJenisSurat($jenis)]
        );

        // Buat tracking initial
        RequestTracking::create([
            'trackable_type' => 'surat',
            'trackable_id' => $surat->id,
            'status' => 'pending',
            'notes' => 'Permohonan surat baru diajukan',
            'updated_by' => null,
        ]);

        // Buat notifikasi untuk semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'actor_id' => Auth::id(),
                'title' => '📄 Pengajuan Surat Baru',
                'message' => Auth::user()->name . ' telah mengajukan surat ' . $this->getNamaJenisSurat($jenis) . '.',
                'type' => 'info',
                'related_type' => 'surat',
                'related_id' => $surat->id,
            ]);
        }

        return redirect()->route('user.surat.index')->with('success', 'Pengajuan surat berhasil dikirim.');
    }

    public function show($id)
    {
        $surat = Surat::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.surat.show', compact('surat'));
    }

    public function edit($id)
    {
        $surat = Surat::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Only allow edit if status is pending or belum_verifikasi
        if (!in_array($surat->status_verifikasi, ['pending', 'belum_verifikasi'])) {
            return redirect()->route('user.surat.index')->with('error', 'Pengajuan surat tidak dapat diedit karena sudah dalam proses verifikasi.');
        }

        $biodata = \App\Models\Biodata::where('user_id', Auth::id())->first();
        $type = $surat->jenis_surat;

        return view('user.surat.edit', compact('surat', 'type', 'biodata'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Only allow update if status is pending or belum_verifikasi
        if (!in_array($surat->status_verifikasi, ['pending', 'belum_verifikasi'])) {
            return redirect()->route('user.surat.index')->with('error', 'Pengajuan surat tidak dapat diupdate karena sudah dalam proses verifikasi.');
        }

        $request->validate([
            'jenis_surat' => 'required|string',
            'attachment' => 'sometimes|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $biodata = \App\Models\Biodata::where('user_id', Auth::id())->first();
        $jenis = strtolower($request->jenis_surat);
        $data = [];

        // type-specific validation and data extraction (same as store)
        if ($jenis == 'ktp') {
            $v = $request->validate([
                'tempat_lahir' => 'nullable|string',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string',
            ]);
            $data = $v;
            $data['nik'] = $biodata->nik ?? '';
            $data['nama_lengkap'] = $biodata->nama_lengkap ?? '';
        } elseif ($jenis == 'sktm') {
            $v = $request->validate([
                'tujuan' => 'required|string',
                'keterangan' => 'nullable|string',
                'jumlah_anggota_keluarga' => 'nullable|integer',
                'alamat' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'domisili') {
            $v = $request->validate([
                'alamat' => 'required|string',
                'keterangan' => 'nullable|string',
                'tujuan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'izin_usaha') {
            $v = $request->validate([
                'nama_usaha' => 'required|string',
                'jenis_usaha' => 'required|string',
                'alamat_usaha' => 'required|string',
                'modal_usaha' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_kelahiran') {
            $v = $request->validate([
                'nama_bayi' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'nama_ibu' => 'required|string',
                'nik_ibu' => 'nullable|digits:16',
                'nama_ayah' => 'required|string',
                'nik_ayah' => 'nullable|digits:16',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_kematian') {
            $v = $request->validate([
                'nama_almarhum' => 'required|string',
                'nik_almarhum' => 'nullable|digits:16',
                'tanggal_meninggal' => 'required|date',
                'tempat_meninggal' => 'required|string',
                'penyebab_kematian' => 'nullable|string',
                'usia' => 'nullable|integer',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_pindah') {
            $v = $request->validate([
                'alamat_asal' => 'required|string',
                'desa_tujuan' => 'required|string',
                'kecamatan_tujuan' => 'required|string',
                'alasan_pindah' => 'nullable|string',
                'jumlah_anggota_keluarga' => 'nullable|integer',
            ]);
            $data = $v;
        } elseif ($jenis == 'surat_rekomendasi') {
            $v = $request->validate([
                'tujuan' => 'required|string',
                'keperluan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'kk_kia') {
            $v = $request->validate([
                'jenis_dokumen' => 'required|in:KK,KIA',
                'nomor_kk' => 'nullable|string',
                'nik_kepala_keluarga' => 'nullable|digits:16',
                'tujuan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'akta_kelahiran') {
            $v = $request->validate([
                'nama_anak' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'tempat_lahir' => 'required|string',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'nama_ibu' => 'required|string',
                'nik_ibu' => 'nullable|digits:16',
                'nama_ayah' => 'required|string',
                'nik_ayah' => 'nullable|digits:16',
                'hari_melapor' => 'required|date',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        } elseif ($jenis == 'izin_imb') {
            $v = $request->validate([
                'alamat_lahan' => 'required|string',
                'luas_tanah' => 'required|string',
                'jenis_bangunan' => 'required|string',
                'luas_bangunan' => 'required|string',
                'fungsi_bangunan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
            $data['nama_pemohon'] = $biodata->nama_lengkap ?? '';
            $data['nik_pemohon'] = $biodata->nik ?? '';
        } elseif ($jenis == 'pembetulan_data') {
            $v = $request->validate([
                'jenis_data' => 'required|string',
                'data_lama' => 'required|string',
                'data_baru' => 'required|string',
                'alasan_pembetulan' => 'required|string',
                'keterangan' => 'nullable|string',
            ]);
            $data = $v;
        }

        $attachmentPath = $surat->attachment;
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($surat->attachment) {
                Storage::disk('public')->delete('surat/' . $surat->attachment);
            }
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('surat', $fileName, 'public');
            $attachmentPath = $fileName;
        }

        $surat->update([
            'jenis_surat' => $jenis,
            'data' => $data,
            'attachment' => $attachmentPath,
        ]);

        // Log surat update
        ActivityLog::log(
            'update',
            'Updated a surat application',
            Auth::id(),
            $surat,
            null,
            ['jenis_surat' => $this->getNamaJenisSurat($jenis)]
        );

        return redirect()->route('user.surat.index')->with('success', 'Pengajuan surat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $surat = Surat::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Only allow delete if status is pending or belum_verifikasi
        if (!in_array($surat->status_verifikasi, ['pending', 'belum_verifikasi'])) {
            return redirect()->route('user.surat.index')->with('error', 'Pengajuan surat tidak dapat dihapus karena sudah dalam proses verifikasi.');
        }

        // Delete attachment if exists
        if ($surat->attachment) {
            Storage::disk('public')->delete('surat/' . $surat->attachment);
        }

        // Log surat deletion
        ActivityLog::log(
            'delete',
            'Deleted a surat application',
            Auth::id(),
            $surat,
            null,
            ['jenis_surat' => $this->getNamaJenisSurat($surat->jenis_surat)]
        );

        $surat->delete();

        return redirect()->route('user.surat.index')->with('success', 'Pengajuan surat berhasil dihapus.');
    }

    // ========== ADMIN ==========
    public function adminIndex(Request $request)
    {
        $query = Surat::with('user');
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status_verifikasi', $request->status);
        }
        $surats = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.surat.index', compact('surats'));
    }

    public function adminShow($id)
    {
        $surat = Surat::with('user','verifier')->findOrFail($id);

        // Prepare a default rendered body to show/edit in admin preview
        $rendered_body = $this->renderSuratBody($surat);

        return view('admin.surat.show', compact('surat', 'rendered_body'));
    }

    public function adminVerify(Request $request, $id)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:sedang_diverifikasi,terverifikasi,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $surat = Surat::findOrFail($id);
        $update = [
            'status_verifikasi' => $request->status_verifikasi,
            'catatan_admin' => $request->catatan_admin,
            'verified_by' => Auth::id(),
        ];
        if ($request->status_verifikasi == 'terverifikasi') {
            $update['verified_at'] = now();
            $update['nomor'] = Surat::generateNomorSurat();
        }

        $surat->update($update);

        return redirect()->route('admin.surat.show', $id)->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function adminDestroy($id)
    {
        $surat = Surat::findOrFail($id);
        if ($surat->attachment) {
            Storage::disk('public')->delete('surat/' . $surat->attachment);
        }
        $surat->delete();
        return redirect()->route('admin.surat.index')->with('success', 'Pengajuan surat dihapus.');
    }

    /**
     * Get nama jenis surat untuk notifikasi
     */
    private function getNamaJenisSurat($jenis)
    {
        $names = [
            'ktp' => 'KTP',
            'sktm' => 'Surat Keterangan Tidak Mampu',
            'domisili' => 'Surat Domisili',
            'izin_usaha' => 'Izin Usaha',
            'surat_kelahiran' => 'Surat Kelahiran',
            'surat_kematian' => 'Surat Kematian',
            'surat_pindah' => 'Surat Pindah',
            'surat_rekomendasi' => 'Surat Rekomendasi',
            'kk_kia' => 'KK/KIA',
            'akta_kelahiran' => 'Akta Kelahiran',
            'izin_imb' => 'Izin Mendirikan Bangunan',
            'pembetulan_data' => 'Pembetulan Data',
        ];
        return $names[$jenis] ?? ucfirst(str_replace('_', ' ', $jenis));
    }

    // Export PDF per-surat has been removed — printing (print view) remains available via `admin.surat.print` route.
    // If needed later, re-introduce export with appropriate authorization and templates.

    /**
     * Show printable view for a Surat (Admin)
     */
    public function printView($id)
    {
        $surat = Surat::with('user.biodata', 'trackingHistory')->findOrFail($id);

        // Check authorization
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tracking = $surat->trackingHistory()->get();

        // Prepare rendered body based on surat type/data
        $rendered_body = $this->renderSuratBody($surat);

        // Generate signature QR for preview/print
        $signature_qr = $this->generateSignatureQrDataUri($surat, $rendered_body);

        // Generate QR content text for display
        $qr_content_text = $this->generateQrContentText($surat, $rendered_body);

        // Also prepare verification URL shown in admin preview (non-sensitive)
        $verification_url = url('/surat/verify') . '?sid=' . $surat->id . '&ts=' . urlencode(now()->toDateTimeString()) . '&sig=' . hash('sha256', $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? ''));

        return view('admin.surat.print', compact('surat', 'tracking', 'rendered_body', 'signature_qr', 'qr_content_text', 'verification_url'));
    }

    /**
     * Preview surat with edited body (admin) — opens printable view with temporary content
     */
    public function preview(Request $request, $id)
    {
        $request->validate([
            'edited_body' => 'nullable|string'
        ]);

        $surat = Surat::with('user.biodata', 'trackingHistory')->findOrFail($id);
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $tracking = $surat->trackingHistory()->get();
        $edited = $request->input('edited_body');
        $rendered_body = $edited ?: $this->renderSuratBody($surat);

        // Generate signature QR for preview (temporary)
        $signature_qr = $this->generateSignatureQrDataUri($surat, $rendered_body);

        // Also generate a compact verification payload so view can display the verification URL if needed
        $verification_url = url('/surat/verify') . '?sid=' . $surat->id . '&ts=' . urlencode(now()->toDateTimeString()) . '&sig=' . hash('sha256', $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? ''));

        return view('admin.surat.print', compact('surat', 'tracking', 'rendered_body', 'signature_qr', 'verification_url'));
    }

    /**
     * Save edited body into surat->data.keterangan (admin)
     */
    public function saveBody(Request $request, $id)
    {
        $request->validate([
            'edited_body' => 'required|string'
        ]);

        $surat = Surat::findOrFail($id);
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $data = $surat->data ?? [];
        $data['keterangan'] = $request->input('edited_body');
        $surat->data = $data;
        $surat->save();

        return redirect()->route('admin.surat.show', $id)->with('success', 'Keterangan surat berhasil disimpan.');
    }

    /**
     * Public verification endpoint for digital signature QR
     */
    public function verifySignature(Request $request)
    {
        $request->validate([
            'sid' => 'required|integer',
            'ts' => 'required|string',
            'sig' => 'required|string',
        ]);

        $sid = $request->input('sid');
        $ts = $request->input('ts');
        $sig = $request->input('sig');

        $surat = Surat::with('user')->find($sid);
        if (!$surat) {
            return view('surat.verify', ['status' => 'not_found', 'message' => 'Surat tidak ditemukan.']);
        }

        // Reconstruct expected hash using current stored data (rendered body)
        $rendered_body = $this->renderSuratBody($surat);
        $expected = hash('sha256', $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? ''));

        $valid = hash_equals($expected, $sig);

        return view('surat.verify', [
            'status' => $valid ? 'valid' : 'invalid',
            'surat' => $surat,
            'signature' => $sig,
            'expected' => $expected,
            'timestamp' => $ts,
        ]);
    }

    /**
     * Verify QR Code with parameter format similar to external system
     * URL format: /pengajuan/ttd?p=surat_id|verifier_id|role|hash
     */
    public function verifyQrCode(Request $request)
    {
        $request->validate([
            'p' => 'required|string',
        ]);

        $param = $request->input('p');

        // Parse the parameter: surat_id|verifier_id|role|hash
        $parts = explode('|', $param);
        if (count($parts) !== 4) {
            return view('surat.verify', [
                'status' => 'invalid',
                'message' => 'Format parameter tidak valid.',
                'surat' => null,
            ]);
        }

        list($surat_id, $verifier_id, $role, $hash) = $parts;

        // Find the surat
        $surat = Surat::with('user', 'verifier')->find($surat_id);
        if (!$surat) {
            return view('surat.verify', [
                'status' => 'not_found',
                'message' => 'Surat tidak ditemukan.',
                'surat' => null,
            ]);
        }

        // Check if surat is verified
        if ($surat->status_verifikasi !== 'terverifikasi') {
            return view('surat.verify', [
                'status' => 'invalid',
                'message' => 'Surat belum terverifikasi.',
                'surat' => $surat,
            ]);
        }

        // Check if verifier matches
        if ($surat->verified_by != $verifier_id) {
            return view('surat.verify', [
                'status' => 'invalid',
                'message' => 'Data verifikasi tidak cocok.',
                'surat' => $surat,
            ]);
        }

        // Verify the hash
        $rendered_body = $this->renderSuratBody($surat);
        $expected_hash = substr(hash('sha256', $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? '')), 0, 3);

        $valid = hash_equals($expected_hash, $hash);

        return view('surat.verify', [
            'status' => $valid ? 'valid' : 'invalid',
            'surat' => $surat,
            'signature' => $hash,
            'expected' => $expected_hash,
            'timestamp' => now()->toDateTimeString(),
            'verifier_info' => [
                'id' => $verifier_id,
                'role' => $role,
            ],
        ]);
    }

    /**
     * Export all Surats to PDF (Admin)
     */
    public function exportAllPdf()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $surats = Surat::with('user')->orderBy('created_at', 'desc')->get();
        
        $filename = 'Laporan_Surat_' . now()->format('Y-m-d') . '.pdf';

        $pdf = PDF::loadView('admin.surat.export-all-pdf', compact('surats'))
            ->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }

    /**
     * Build a coherent human-readable body for the surat based on its type and stored data
     */
    private function renderSuratBody($surat)
    {
        $data = is_array($surat->data) ? $surat->data : (array) $surat->data;

        // If explicit keterangan was provided, prefer that
        if (!empty($data['keterangan'])) {
            return $data['keterangan'];
        }

        $type = $surat->jenis_surat;

        // Specific rendering per jenis surat
        if ($type === 'ktp') {
            $nama = $data['nama_lengkap'] ?? $data['nama'] ?? '-';
            $nik = $data['nik'] ?? '-';
            $tempat = $data['tempat_lahir'] ?? '';
            $tgl = $data['tanggal_lahir'] ?? '';
            $alamat = $data['alamat'] ?? ($data['alamat_lengkap'] ?? '-');

            $ttl = trim(($tempat ? "$tempat, " : '') . ($tgl ?: ''));

            return "Menerangkan bahwa $nama, NIK $nik, lahir di $ttl, bertempat tinggal di $alamat. Surat keterangan ini dibuat untuk keperluan pengajuan KTP / administrasi kependudukan sesuai data yang diajukan.";
        }

        if ($type === 'sktm') {
            $nama = $data['nama_lengkap'] ?? $data['nama'] ?? '-';
            $nik = $data['nik'] ?? '-';
            $alamat = $data['alamat'] ?? ($data['alamat_lengkap'] ?? '-');
            $anggota = $data['jumlah_anggota_keluarga'] ?? null;
            $tujuan = $data['tujuan'] ?? '';

            $text = "Menerangkan bahwa $nama";
            if ($nik) $text .= ", NIK $nik";
            $text .= ", yang berdomisili di $alamat";
            if ($anggota) $text .= ", dengan jumlah anggota keluarga $anggota";
            $text .= ". Berdasarkan verifikasi, yang bersangkutan termasuk keluarga kurang mampu.";
            if ($tujuan) $text .= " Surat ini dibuat untuk keperluan: $tujuan.";

            return $text;
        }

        if ($type === 'domisili') {
            $nama = $data['nama_lengkap'] ?? $data['nama'] ?? '-';
            $alamat = $data['alamat'] ?? ($data['alamat_lengkap'] ?? '-');
            $tujuan = $data['tujuan'] ?? '';

            $text = "Menerangkan bahwa $nama berdomisili di $alamat.";
            if ($tujuan) $text .= " Surat ini dibuat untuk keperluan: $tujuan.";
            return $text;
        }

        if ($type === 'surat_kelahiran') {
            $anak = $data['nama_bayi'] ?? 'Anak';
            $tgl = $data['tanggal_lahir'] ?? '';
            $tempat = $data['tempat_lahir'] ?? '';
            $ibu = $data['nama_ibu'] ?? '';
            $ayah = $data['nama_ayah'] ?? '';
            return "Menerangkan bahwa $anak lahir pada $tgl di $tempat sebagai anak dari $ibu dan $ayah.";
        }

        if ($type === 'surat_kematian') {
            $nama = $data['nama_almarhum'] ?? '';
            $tgl = $data['tanggal_meninggal'] ?? '';
            $tempat = $data['tempat_meninggal'] ?? '';
            return "Menerangkan bahwa $nama telah meninggal dunia pada $tgl di $tempat.";
        }

        if ($type === 'pembetulan_data') {
            $jenis = $data['jenis_data'] ?? 'Data';
            $lama = $data['data_lama'] ?? '';
            $baru = $data['data_baru'] ?? '';
            $alasan = $data['alasan_pembetulan'] ?? '';
            return "Permohonan pembetulan $jenis:\nData Lama: $lama\nData Baru: $baru\nAlasan: $alasan";
        }

        // Undangan-like: has date/place/time/acara
        if (!empty($data['hari']) || !empty($data['tanggal']) || !empty($data['tempat']) || !empty($data['jam']) || !empty($data['acara'])) {
            $parts = [];
            if (!empty($data['hari']) || !empty($data['tanggal'])) {
                $parts[] = 'Hari / Tanggal : ' . trim(($data['hari'] ?? '') . ' ' . ($data['tanggal'] ?? ''));
            }
            if (!empty($data['tempat'])) {
                $parts[] = 'Tempat : ' . $data['tempat'];
            }
            if (!empty($data['jam'])) {
                $parts[] = 'Jam : ' . $data['jam'];
            }
            if (!empty($data['acara'])) {
                $parts[] = 'Acara : ' . $data['acara'];
            }

            return "Mengharapkan kehadiran saudara untuk dapat hadir pada:\n" . implode("\n", $parts);
        }

        // Default: show a generic summary using available keys
        if (!empty($data)) {
            $pairs = [];
            foreach ($data as $k => $v) {
                if (is_array($v)) $v = json_encode($v, JSON_UNESCAPED_UNICODE);
                $pairs[] = ucfirst(str_replace('_',' ', $k)) . ': ' . $v;
            }
            return implode("\n", $pairs);
        }

        return 'Keterangan tidak tersedia.';
    }

    /**
     * Generate a signature QR data URI for embedding in PDFs or print views
     * Now generates URL format for verified documents
     */
    private function generateQrContentText($surat, $rendered_body = '')
    {
        // Only show URL for verified surat
        if ($surat->status_verifikasi !== 'terverifikasi' || !$surat->verified_by) {
            return "Surat belum terverifikasi. QR code akan muncul setelah surat diverifikasi oleh admin.";
        }

        // Get verifier information
        $verifier = $surat->verifier;
        $verifierRole = $verifier ? $verifier->role : 'admin';

        // Map role to the expected format
        $roleMapping = [
            'admin' => 'kepsek',
            'user' => 'user',
        ];
        $mappedRole = $roleMapping[$verifierRole] ?? 'kepsek';

        // Generate hash (short hash of surat id, verifier id, and content)
        $hashString = $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? '');
        $shortHash = substr(hash('sha256', $hashString), 0, 3);

        // Create URL parameter
        $param = $surat->id . '|' . $surat->verified_by . '|' . $mappedRole . '|' . $shortHash;

        // Create full URL using the system's base URL
        $baseUrl = config('app.url', 'http://localhost');
        $qrUrl = $baseUrl . '/pengajuan/ttd?p=' . $param;

        return "Scan QR code untuk verifikasi digital:\n" . $qrUrl;
    }

    private function generateSignatureQrDataUri($surat, $rendered_body = '')
    {
        try {
            // Only generate QR for verified surat
            if ($surat->status_verifikasi !== 'terverifikasi' || !$surat->verified_by) {
                return 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200"><rect width="200" height="200" fill="#f0f0f0"/><text x="100" y="100" text-anchor="middle" font-family="Arial" font-size="12" fill="#666">Belum Terverifikasi</text></svg>');
            }

            // Get verifier information
            $verifier = $surat->verifier;
            $verifierRole = $verifier ? $verifier->role : 'admin';

            // Map role to the expected format
            $roleMapping = [
                'admin' => 'kepsek',
                'user' => 'user',
            ];
            $mappedRole = $roleMapping[$verifierRole] ?? 'kepsek';

            // Generate hash (short hash of surat id, verifier id, and content)
            $hashString = $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? '');
            $shortHash = substr(hash('sha256', $hashString), 0, 3);

            // Create URL parameter
            $param = $surat->id . '|' . $surat->verified_by . '|' . $mappedRole . '|' . $shortHash;

            // Create full URL using the system's base URL
            $baseUrl = config('app.url', 'http://localhost');
            $qrUrl = $baseUrl . '/pengajuan/ttd?p=' . urlencode($param);

            // Generate QR as SVG for display
            try {
                $svg = QrCode::format('svg')->size(200)->generate($qrUrl);
                if ($svg) {
                    return 'data:image/svg+xml;base64,' . base64_encode($svg);
                }
            } catch (\Exception $e) {
                // ignore and fallback
            }

            // Fallback to Google Chart URL encoding
            $fallbackUrl = 'https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=' . urlencode($qrUrl) . '&chld=L|1';

            // Try to fetch server-side
            $img = @file_get_contents($fallbackUrl);
            if (!$img) {
                try {
                    $resp = Http::timeout(5)->get($fallbackUrl);
                    if ($resp->ok()) {
                        $img = $resp->body();
                    }
                } catch (\Exception $e) {
                    $img = null;
                }
            }

            if ($img) {
                return 'data:image/png;base64,' . base64_encode($img);
            }

            // If all else fails, return a placeholder
            return 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200"><rect width="200" height="200" fill="#f0f0f0"/><text x="100" y="100" text-anchor="middle" font-family="Arial" font-size="12" fill="#666">QR Code Error</text></svg>');

        } catch (\Exception $e) {
            // Return error placeholder
            return 'data:image/svg+xml;base64,' . base64_encode('<svg width="200" height="200"><rect width="200" height="200" fill="#ffcccc"/><text x="100" y="100" text-anchor="middle" font-family="Arial" font-size="12" fill="#cc0000">Error</text></svg>');
        }
    }

    /**
     * Printable view for surat (User)
     */
    public function userPrintView($id)
    {
        $surat = Surat::with('user.biodata', 'trackingHistory')->findOrFail($id);
        if ($surat->user_id !== auth()->id()) {
            abort(403);
        }

        // Check if surat has been verified by admin
        if ($surat->status_verifikasi !== 'terverifikasi') {
            return redirect()->route('user.surat.show', $id)->with('error', 'Surat belum dapat dicetak karena belum diverifikasi oleh admin.');
        }

        $tracking = $surat->trackingHistory()->get();

        // Prepare rendered body based on surat type/data
        $rendered_body = $this->renderSuratBody($surat);

        // Generate signature QR for preview/print
        $signature_qr = $this->generateSignatureQrDataUri($surat, $rendered_body);

        // Generate QR content text for display
        $qr_content_text = $this->generateQrContentText($surat, $rendered_body);

        // Also prepare verification URL shown in user preview (non-sensitive)
        $verification_url = url('/surat/verify') . '?sid=' . $surat->id . '&ts=' . urlencode(now()->toDateTimeString()) . '&sig=' . hash('sha256', $surat->id . '|' . ($surat->jenis_surat ?? '') . '|' . ($rendered_body ?? '') . '|' . (config('app.key') ?? ''));

        return view('user.surat.print', compact('surat', 'tracking', 'rendered_body', 'signature_qr', 'qr_content_text', 'verification_url'));
    }
}

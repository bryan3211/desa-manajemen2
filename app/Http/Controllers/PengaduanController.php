<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Notification;
use App\Models\RequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class PengaduanController extends Controller
{
    // ==================== USER METHODS ====================

    /**
     * Display a listing of pengaduan for user
     */
    public function index()
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.pengaduan.index', compact('pengaduan'));
    }

    /**
     * Show the form for creating a new pengaduan
     */
    public function create()
    {
        return view('user.pengaduan.create');
    }

    /**
     * Store a newly created pengaduan
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:infrastruktur,pelayanan_publik,keamanan,lingkungan,sosial_kemasyarakatan,lainnya',
            'judul_pengaduan' => 'required|string|max:255',
            'isi_pengaduan' => 'required|string',
            'lokasi_kejadian' => 'required|string|max:255',
            'bukti_lampiran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'nomor_pengaduan' => Pengaduan::generateNomorPengaduan(),
            'kategori' => $request->kategori,
            'judul_pengaduan' => $request->judul_pengaduan,
            'isi_pengaduan' => $request->isi_pengaduan,
            'lokasi_kejadian' => $request->lokasi_kejadian,
            'status' => 'pending',
        ];

        if ($request->hasFile('bukti_lampiran')) {
            $file = $request->file('bukti_lampiran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('pengaduan', $fileName, 'public');
            $data['bukti_lampiran'] = $fileName;
        }

        $pengaduan = Pengaduan::create($data);

        // Log pengaduan creation
        ActivityLog::log(
            'create',
            'Created a new pengaduan',
            Auth::id(),
            $pengaduan,
            null,
            ['nomor_pengaduan' => $pengaduan->nomor_pengaduan, 'kategori' => $request->kategori]
        );

        // Buat tracking initial
        RequestTracking::create([
            'trackable_type' => 'pengaduan',
            'trackable_id' => $pengaduan->id,
            'status' => 'pending',
            'notes' => 'Pengaduan baru dibuat',
            'updated_by' => null,
        ]);

        // Buat notifikasi untuk semua admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'actor_id' => Auth::id(),
                'title' => '⚠️ Pengaduan Baru Masuk',
                'message' => Auth::user()->name . ' telah membuat pengaduan baru: ' . $pengaduan->judul_pengaduan,
                'type' => 'warning',
                'related_type' => 'pengaduan',
                'related_id' => $pengaduan->id,
            ]);
        }

        return redirect()->route('user.pengaduan.index')
            ->with('success', 'Pengaduan berhasil diajukan. Nomor pengaduan: ' . $data['nomor_pengaduan']);
    }

    /**
     * Display the specified pengaduan
     */
    public function show($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('user.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Remove the specified pengaduan
     */
    public function destroy($id)
    {
        $pengaduan = Pengaduan::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        if ($pengaduan->bukti_lampiran) {
            Storage::disk('public')->delete('pengaduan/' . $pengaduan->bukti_lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('user.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }

    // ==================== ADMIN METHODS ====================

    /**
     * Display all pengaduan for admin
     */
    public function adminIndex()
    {
        $pengaduan = Pengaduan::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $statistik = [
            'total' => Pengaduan::count(),
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        $kategori_stats = [
            'infrastruktur' => Pengaduan::where('kategori', 'infrastruktur')->count(),
            'pelayanan_publik' => Pengaduan::where('kategori', 'pelayanan_publik')->count(),
            'keamanan' => Pengaduan::where('kategori', 'keamanan')->count(),
            'lingkungan' => Pengaduan::where('kategori', 'lingkungan')->count(),
            'sosial_kemasyarakatan' => Pengaduan::where('kategori', 'sosial_kemasyarakatan')->count(),
            'lainnya' => Pengaduan::where('kategori', 'lainnya')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduan', 'statistik', 'kategori_stats'));
    }

    /**
     * Show detail pengaduan for admin
     */
    public function adminShow($id)
    {
        $pengaduan = Pengaduan::with(['user', 'admin'])->findOrFail($id);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    /**
     * Update pengaduan (admin)
     */
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'tanggapan_admin' => 'required|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        $pengaduan->update([
            'status' => $request->status,
            'tanggapan_admin' => $request->tanggapan_admin,
            'tanggal_tanggapan' => now(),
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.pengaduan.show', $id)
            ->with('success', 'Tanggapan pengaduan berhasil disimpan');
    }

    /**
     * Filter pengaduan (admin)
     */
    public function adminFilter(Request $request)
    {
        $query = Pengaduan::with('user');

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('kategori') && $request->kategori != 'all') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_pengaduan', 'like', "%{$search}%")
                  ->orWhere('nomor_pengaduan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $pengaduan = $query->orderBy('created_at', 'desc')->paginate(15);

        $statistik = [
            'total' => Pengaduan::count(),
            'pending' => Pengaduan::where('status', 'pending')->count(),
            'diproses' => Pengaduan::where('status', 'diproses')->count(),
            'selesai' => Pengaduan::where('status', 'selesai')->count(),
            'ditolak' => Pengaduan::where('status', 'ditolak')->count(),
        ];

        return view('admin.pengaduan.index', compact('pengaduan', 'statistik'));
    }

    /**
     * Delete pengaduan (admin)
     */
    public function adminDestroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->bukti_lampiran) {
            Storage::disk('public')->delete('pengaduan/' . $pengaduan->bukti_lampiran);
        }

        $pengaduan->delete();

        return redirect()->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus');
    }
}
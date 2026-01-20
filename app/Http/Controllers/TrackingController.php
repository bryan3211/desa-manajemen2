<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pengaduan;
use App\Models\RequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    /**
     * Display tracking page for all requests
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's surats and pengaduan
        $surats = $user->surats()->with('trackingHistory')->get();
        $pengaduan = $user->pengaduan()->with('trackingHistory')->get();
        
        return view('tracking.index', compact('surats', 'pengaduan'));
    }

    /**
     * Show detailed tracking for a surat
     */
    public function showSurat($id)
    {
        $surat = Surat::findOrFail($id);
        
        // Check if user owns this surat
        if ($surat->user_id !== Auth::id()) {
            abort(403);
        }

        $tracking = $surat->trackingHistory()->get();
        
        return view('tracking.surat-detail', compact('surat', 'tracking'));
    }

    /**
     * Show detailed tracking for a pengaduan
     */
    public function showPengaduan($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Check if user owns this pengaduan
        if ($pengaduan->user_id !== Auth::id()) {
            abort(403);
        }

        $tracking = $pengaduan->trackingHistory()->get();
        
        return view('tracking.pengaduan-detail', compact('pengaduan', 'tracking'));
    }

    /**
     * Admin: Update tracking status for surat
     */
    public function updateSuratStatus(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $admin = Auth::user();

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak,revisi',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create tracking record
        RequestTracking::create([
            'trackable_type' => 'surat',
            'trackable_id' => $surat->id,
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_by' => $admin->id,
        ]);

        // Update surat status
        $surat->update([
            'status_verifikasi' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status tracking berhasil diperbarui',
            'data' => [
                'status' => $request->status,
                'updated_by' => $admin->name,
                'timestamp' => now()->format('d M Y H:i'),
            ]
        ]);
    }

    /**
     * Admin: Update tracking status for pengaduan
     */
    public function updatePengaduanStatus(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $admin = Auth::user();

        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak,revisi',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create tracking record
        RequestTracking::create([
            'trackable_type' => 'pengaduan',
            'trackable_id' => $pengaduan->id,
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_by' => $admin->id,
        ]);

        // Update pengaduan status
        $pengaduan->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status tracking berhasil diperbarui',
            'data' => [
                'status' => $request->status,
                'updated_by' => $admin->name,
                'timestamp' => now()->format('d M Y H:i'),
            ]
        ]);
    }

    /**
     * Get tracking timeline as JSON (for AJAX)
     */
    public function getTrackingTimeline($type, $id)
    {
        if ($type === 'surat') {
            $request = Surat::findOrFail($id);
        } else {
            $request = Pengaduan::findOrFail($id);
        }

        // Check authorization
        if ($request->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $tracking = $request->trackingHistory()
            ->with('updatedBy')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'status' => $item->status,
                    'status_label' => $item->status_label,
                    'status_icon' => $item->status_icon,
                    'status_badge' => $item->status_badge,
                    'notes' => $item->notes,
                    'updated_by' => $item->updatedBy?->name ?? 'System',
                    'timestamp' => $item->created_at->format('d M Y H:i'),
                    'timestamp_ago' => $item->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $tracking,
        ]);
    }
}

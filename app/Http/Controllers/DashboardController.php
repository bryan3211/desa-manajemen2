<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Pengaduan;
use App\Models\RequestTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Get recent status updates for user dashboard
     */
    public function getRecentUpdates()
    {
        try {
            $user = Auth::user();
            
            // Get recent tracking updates dari surat dan pengaduan user
            $suratIds = Surat::where('user_id', $user->id)->pluck('id');
            $pengaduanIds = Pengaduan::where('user_id', $user->id)->pluck('id');

            $updates = [];

            // Get recent surat updates
            if ($suratIds->isNotEmpty()) {
                $suratUpdates = RequestTracking::where('trackable_type', 'surat')
                    ->whereIn('trackable_id', $suratIds)
                    ->with('trackable')
                    ->latest('created_at')
                    ->limit(5)
                    ->get();

                foreach ($suratUpdates as $update) {
                    if (!$update->trackable) continue;
                    
                    $surat = $update->trackable;
                    $badge = $this->getStatusBadge($update->status);
                    $updates[] = [
                        'type' => 'surat',
                        'id' => $update->id,
                        'title' => ucfirst(str_replace('_', ' ', $surat->jenis_surat)),
                        'message' => 'Status: ' . $this->getStatusLabel($update->status),
                        'status' => $this->getStatusLabel($update->status),
                        'status_label' => $this->getStatusLabel($update->status),
                        'emoji' => $badge['emoji'],
                        'badge_color' => $badge['color'],
                        'badge_text_color' => $badge['text'],
                        'notes' => $update->notes,
                        'timestamp' => $update->created_at,
                        'time_ago' => $update->created_at->diffForHumans(),
                        'tracking_link' => route('user.tracking.surat', $surat->id),
                    ];
                }
            }

            // Get recent pengaduan updates
            if ($pengaduanIds->isNotEmpty()) {
                $pengaduanUpdates = RequestTracking::where('trackable_type', 'pengaduan')
                    ->whereIn('trackable_id', $pengaduanIds)
                    ->with('trackable')
                    ->latest('created_at')
                    ->limit(5)
                    ->get();

                foreach ($pengaduanUpdates as $update) {
                    if (!$update->trackable) continue;
                    
                    $pengaduan = $update->trackable;
                    $badge = $this->getStatusBadge($update->status);
                    $updates[] = [
                        'type' => 'pengaduan',
                        'id' => $update->id,
                        'title' => substr($pengaduan->judul_pengaduan, 0, 40),
                        'message' => 'Status: ' . $this->getStatusLabel($update->status),
                        'status' => $this->getStatusLabel($update->status),
                        'status_label' => $this->getStatusLabel($update->status),
                        'emoji' => $badge['emoji'],
                        'badge_color' => $badge['color'],
                        'badge_text_color' => $badge['text'],
                        'notes' => $update->notes,
                        'timestamp' => $update->created_at,
                        'time_ago' => $update->created_at->diffForHumans(),
                        'tracking_link' => route('user.tracking.pengaduan', $pengaduan->id),
                    ];
                }
            }

            // Sort by timestamp descending and take top 5
            usort($updates, function ($a, $b) {
                return $b['timestamp']->timestamp <=> $a['timestamp']->timestamp;
            });
            $updates = array_slice($updates, 0, 5);

            return response()->json([
                'success' => true,
                'data' => $updates,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Get status label
     */
    private function getStatusLabel($status)
    {
        return [
            'pending' => 'Menunggu Diproses',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'revisi' => 'Butuh Revisi',
        ][$status] ?? 'Tidak Diketahui';
    }

    /**
     * Get status badge color
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => ['color' => 'rgba(245, 158, 11, 0.2)', 'text' => '#f59e0b', 'emoji' => '⏳'],
            'diproses' => ['color' => 'rgba(59, 130, 246, 0.2)', 'text' => '#3b82f6', 'emoji' => '⚙️'],
            'selesai' => ['color' => 'rgba(16, 185, 129, 0.2)', 'text' => '#10b981', 'emoji' => '✅'],
            'ditolak' => ['color' => 'rgba(239, 68, 68, 0.2)', 'text' => '#ef4444', 'emoji' => '❌'],
            'revisi' => ['color' => 'rgba(107, 114, 128, 0.2)', 'text' => '#6b7280', 'emoji' => '📝'],
        ];

        return $badges[$status] ?? ['color' => 'rgba(107, 114, 128, 0.2)', 'text' => '#6b7280',] ;
    }

    /**
     * Get recent updates for admin dashboard
     */
    public function getAdminRecentUpdates()
    {
        try {
            // Get latest tracking updates from all surat and pengaduan
            $suratUpdates = RequestTracking::where('trackable_type', 'surat')
                ->with('trackable', 'updatedBy')
                ->latest('created_at')
                ->limit(5)
                ->get();

            $pengaduanUpdates = RequestTracking::where('trackable_type', 'pengaduan')
                ->with('trackable', 'updatedBy')
                ->latest('created_at')
                ->limit(5)
                ->get();

            $updates = [];

            foreach ($suratUpdates as $update) {
                if (!$update->trackable) continue;
                
                $surat = $update->trackable;
                if (!$surat->user) continue;
                
                $badge = $this->getStatusBadge($update->status);
                $updates[] = [
                    'type' => 'surat',
                    'id' => $update->id,
                    'title' => ucfirst(str_replace('_', ' ', $surat->jenis_surat)) . ' - ' . $surat->user->name,
                    'message' => 'Status: ' . $this->getStatusLabel($update->status),
                    'status' => $this->getStatusLabel($update->status),
                    'status_label' => $this->getStatusLabel($update->status),
                    'emoji' => $badge['emoji'],
                    'badge_color' => $badge['color'],
                    'badge_text_color' => $badge['text'],
                    'notes' => $update->notes,
                    'updated_by' => $update->updatedBy?->name ?? 'System',
                    'timestamp' => $update->created_at,
                    'time_ago' => $update->created_at->diffForHumans(),
                    'tracking_link' => route('admin.surat.show', $surat->id),
                ];
            }

            foreach ($pengaduanUpdates as $update) {
                if (!$update->trackable) continue;
                
                $pengaduan = $update->trackable;
                if (!$pengaduan->user) continue;
                
                $badge = $this->getStatusBadge($update->status);
                $updates[] = [
                    'type' => 'pengaduan',
                    'id' => $update->id,
                    'title' => substr($pengaduan->judul_pengaduan, 0, 40) . ' - ' . $pengaduan->user->name,
                    'message' => 'Status: ' . $this->getStatusLabel($update->status),
                    'status' => $this->getStatusLabel($update->status),
                    'status_label' => $this->getStatusLabel($update->status),
                    'emoji' => $badge['emoji'],
                    'badge_color' => $badge['color'],
                    'badge_text_color' => $badge['text'],
                    'notes' => $update->notes,
                    'updated_by' => $update->updatedBy?->name ?? 'System',
                    'timestamp' => $update->created_at,
                    'time_ago' => $update->created_at->diffForHumans(),
                    'tracking_link' => route('admin.pengaduan.show', $pengaduan->id),
                ];
            }

            // Sort by timestamp descending and take top 10
            usort($updates, function ($a, $b) {
                return $b['timestamp']->timestamp <=> $a['timestamp']->timestamp;
            });
            $updates = array_slice($updates, 0, 10);

            return response()->json([
                'success' => true,
                'data' => $updates,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Get real-time statistics
     */
    public function getStatistics()
    {
        try {
            // Get current date info
            $today = now()->format('Y-m-d');
            $thisMonth = now()->format('Y-m');
            $thisYear = now()->format('Y');

            // Count visitors today
            $visitorsToday = \DB::table('visitors')
                ->whereDate('created_at', $today)
                ->count();

            // Count visitors this month
            $visitorsMonth = \DB::table('visitors')
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$thisMonth])
                ->count();

            // Count visitors this year
            $visitorsYear = \DB::table('visitors')
                ->whereRaw("YEAR(created_at) = ?", [$thisYear])
                ->count();

            // Count downloads
            $downloads = \DB::table('visitors')
                ->where('action', 'download')
                ->count();

            // Get total users
            $totalUsers = \App\Models\User::where('role', 'user')->count();

            // Get total surats
            $totalSurats = Surat::count();

            // Get total reviews
            $totalReviews = \App\Models\Review::where('is_approved', true)->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'visitors_today' => $visitorsToday,
                    'visitors_month' => $visitorsMonth,
                    'visitors_year' => $visitorsYear,
                    'downloads' => $downloads,
                    'total_users' => $totalUsers,
                    'total_surats' => $totalSurats,
                    'total_pengaduans' => $totalPengaduans,
                    'total_reviews' => $totalReviews,
                    'timestamp' => now()->toIso8601String(),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
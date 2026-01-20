<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'user_id', 'jenis_surat', 'nomor', 'data', 'attachment', 'status_verifikasi', 'catatan_admin', 'verified_by', 'verified_at'
    ];

    protected $casts = [
        'data' => 'array',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get all tracking history
     */
    public function trackingHistory()
    {
        return $this->morphMany(RequestTracking::class, 'trackable')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get latest tracking status
     */
    public function latestTracking()
    {
        return $this->trackingHistory()->first();
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu Diproses',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
            'revisi' => 'Butuh Revisi',
        ][$this->status_verifikasi] ?? 'Tidak Diketahui';
    }

        /**
         * Get status badge
         */
        public function getStatusBadgeAttribute()
        {
            return [
                'pending' => 'warning',
                'diproses' => 'info',
                'selesai' => 'success',
                'ditolak' => 'danger',
                'revisi' => 'secondary',
            ][$this->status_verifikasi] ?? 'secondary';
        }

    /**
     * Generate nomor surat otomatis
     */
    public static function generateNomorSurat()
    {
        $tahun = date('Y');
        
        $lastSurat = self::where('nomor', 'like', '%/' . $tahun)
            ->orderBy('id', 'desc')
            ->first();
        
        if ($lastSurat && $lastSurat->nomor) {
            // Extract the sequential number from the last nomor
            $parts = explode('/', $lastSurat->nomor);
            $urutan = intval($parts[0]) + 1;
        } else {
            $urutan = 1;
        }
        
        return $urutan . '/644/402.406.04/' . $tahun;
    }
}

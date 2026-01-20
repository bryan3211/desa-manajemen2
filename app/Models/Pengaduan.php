<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'user_id',
        'nomor_pengaduan',
        'kategori',             
        'judul_pengaduan',
        'isi_pengaduan',
        'lokasi_kejadian',       
        'bukti_lampiran',
        'status',
        'tanggapan_admin',
        'tanggal_tanggapan',
        'admin_id',
];

    protected $casts = [
        'tanggal_tanggapan' => 'datetime',
    ];

    /**
     * Relasi ke User (pembuat pengaduan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Admin (yang menanggapi)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Generate nomor pengaduan otomatis
     */
    public static function generateNomorPengaduan()
    {
        $tahun = date('Y');
        $bulan = date('m');
        
        $lastPengaduan = self::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('id', 'desc')
            ->first();
        
        $urutan = $lastPengaduan ? intval(substr($lastPengaduan->nomor_pengaduan, -4)) + 1 : 1;
        
        return 'ADU/' . $tahun . '/' . $bulan . '/' . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return [
            'pending' => 'warning',
            'diproses' => 'info',
            'selesai' => 'success',
            'ditolak' => 'danger',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu Proses',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ][$this->status] ?? 'Tidak Diketahui';
    }

    /**
     * Get kategori label
     */
    public function getKategoriLabelAttribute()
    {
        return [
            'infrastruktur' => 'Infrastruktur (Jalan, Jembatan, dll)',
            'pelayanan_publik' => 'Pelayanan Publik',
            'keamanan' => 'Keamanan & Keselamatan',
            'lingkungan' => 'Lingkungan & Kebersihan',
            'sosial_kemasyarakatan' => 'Sosial Kemasyarakatan',
            'lainnya' => 'Lainnya',
        ][$this->kategori] ?? 'Tidak Diketahui';
    }

    /**
     * Get kategori icon
     */
    public function getKategoriIconAttribute()
    {
        return [
            'infrastruktur' => 'ti-build',
            'pelayanan_publik' => 'ti-users',
            'keamanan' => 'ti-shield',
            'lingkungan' => 'ti-leaf',
            'sosial_kemasyarakatan' => 'ti-heart',
            'lainnya' => 'ti-help',
        ][$this->kategori] ?? 'ti-help';
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
}
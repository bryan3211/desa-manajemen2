<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestTracking extends Model
{
    use HasFactory;

    protected $table = 'request_tracking';

    protected $fillable = [
        'trackable_type',
        'trackable_id',
        'status',
        'notes',
        'updated_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'status_label',
        'status_badge',
        'status_icon',
    ];

    /**
     * Get the trackable model (Surat or Pengaduan)
     */
    public function trackable()
    {
        return $this->morphTo();
    }

    /**
     * Get the admin who updated the status
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
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
        ][$this->status] ?? 'Tidak Diketahui';
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
            'revisi' => 'secondary',
        ][$this->status] ?? 'secondary';
    }

    /**
     * Get status icon
     */
    public function getStatusIconAttribute()
    {
        return [
            'pending' => '⏳',
            'diproses' => '⚙️',
            'selesai' => '✅',
            'ditolak' => '❌',
            'revisi' => '📝',
        ][$this->status] ?? '';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $table = 'biodata';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'pekerjaan',
        'kewarganegaraan',
        'alamat_lengkap',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_pos',
        'no_hp',
        'email',
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_terakhir',
        'foto_ktp',
        'foto_kk',
        'foto_diri',
        'status_verifikasi',
        'catatan_admin',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'verified_at' => 'datetime',
    ];

    /**
     * Relasi ke User (pemilik biodata)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke Admin (yang memverifikasi)
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return [
            'belum_verifikasi' => 'secondary',
            'sedang_diverifikasi' => 'warning',
            'terverifikasi' => 'success',
            'ditolak' => 'danger',
        ][$this->status_verifikasi] ?? 'secondary';
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return [
            'belum_verifikasi' => 'Belum Verifikasi',
            'sedang_diverifikasi' => 'Sedang Diverifikasi',
            'terverifikasi' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
        ][$this->status_verifikasi] ?? 'Tidak Diketahui';
    }

    /**
     * Get umur
     */
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    /**
     * Get alamat lengkap dengan RT/RW
     */
    public function getAlamatLengkapFormatAttribute()
    {
        if (!$this->alamat_lengkap) {
            return '-';
        }
        
        return $this->alamat_lengkap . ', RT ' . $this->rt . '/RW ' . $this->rw . ', ' .
               $this->desa_kelurahan . ', ' . $this->kecamatan . ', ' .
               $this->kabupaten_kota . ', ' . $this->provinsi . ' ' . $this->kode_pos;
    }

    /**
     * Check if biodata is complete
     */
    public function isComplete()
    {
        $requiredFields = [
            'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'pekerjaan',
            'alamat_lengkap', 'rt', 'rw', 'desa_kelurahan', 'kecamatan',
            'kabupaten_kota', 'provinsi', 'kode_pos', 'no_hp',
            'nama_ayah', 'nama_ibu'
        ];

        foreach ($requiredFields as $field) {
            if (empty($this->$field)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentageAttribute()
    {
        $totalFields = 28;
        $filledFields = 0;

        $fieldsToCheck = [
            'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'agama', 'status_perkawinan', 'pekerjaan',
            'kewarganegaraan', 'alamat_lengkap', 'rt', 'rw',
            'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi',
            'kode_pos', 'no_hp', 'email', 'nama_ayah', 'nama_ibu',
            'pekerjaan_ayah', 'pekerjaan_ibu', 'pendidikan_terakhir',
            'foto_ktp', 'foto_kk', 'foto_diri'
        ];

        foreach ($fieldsToCheck as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        return round(($filledFields / $totalFields) * 100);
    }
}
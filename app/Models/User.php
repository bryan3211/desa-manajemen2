<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nik',
        'password',
        'role',
        'avatar',
        'provider',
        'provider_id',
        'is_verified',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Biodata
     */
    public function biodata()
    {
        return $this->hasOne(Biodata::class);
    }

    /**
     * Relasi ke Pengaduan sebagai pembuat
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }

    /**
     * Relasi ke Pengaduan sebagai admin yang menanggapi
     */
    public function pengaduanDitanggapi()
    {
        return $this->hasMany(Pengaduan::class, 'admin_id');
    }

    /**
     * Relasi ke Notification
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Relasi ke Surat sebagai pembuat
     */
    public function surats()
    {
        return $this->hasMany(Surat::class);
    }
}
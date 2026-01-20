<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agenda extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date_start',
        'date_end',
        'location',
        'status',
        'image',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Get the documentations for the agenda.
     */
    public function documentations(): HasMany
    {
        return $this->hasMany(AgendaDocumentation::class);
    }

    /**
     * Scope untuk agenda yang dipublikasikan
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope untuk agenda upcoming
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Scope untuk agenda ongoing
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope untuk agenda done
     */
    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'upcoming' => 'info',
            'ongoing' => 'success',
            'done' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'upcoming' => 'Akan Datang',
            'ongoing' => 'Sedang Berlangsung',
            'done' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgendaDocumentation extends Model
{
    protected $fillable = [
        'agenda_id',
        'image_url',
        'caption',
    ];

    /**
     * Get the agenda that owns the documentation.
     */
    public function agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bupot extends Model
{
    protected $guarded = ['id'];

    public function pembuat(): BelongsTo {
        return $this->belongsTo(Sistem::class, 'pembuat_id');
    }

    public function representatif(): BelongsTo {
        return $this->belongsTo(Sistem::class, 'representatif_id');
    }

    public function penandatangan(): BelongsTo {
        return $this->belongsTo(BupotTandaTangan::class);
    }

    public function bupot_dokumens(): HasMany
    {
        return $this->hasMany(BupotDokumen::class);
    }
}

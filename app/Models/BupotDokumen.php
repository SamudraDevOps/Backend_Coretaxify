<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BupotDokumen extends Model
{
    protected $guarded = ['id'];

    public function bupot(): BelongsTo
    {
        return $this->belongsTo(Bupot::class);
    }
}

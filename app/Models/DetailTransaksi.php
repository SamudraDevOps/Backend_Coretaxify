<?php

namespace App\Models;

use App\Models\Faktur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $guarded = ['id'];

    public function faktur(): BelongsTo {
        return $this->belongsTo(Faktur::class);
    }
}

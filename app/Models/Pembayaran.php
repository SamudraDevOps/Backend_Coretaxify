<?php

namespace App\Models;

use App\Models\Sistem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $guarded = ['id'];

    public function sistem(): BelongsTo
    {
        return $this->belongsTo(Sistem::class, 'badan_id');
    }

    public function kap_kjs(): BelongsTo
    {
        return $this->belongsTo(KapKjs::class);
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(Sistem::class, 'pic_id');
    }
}

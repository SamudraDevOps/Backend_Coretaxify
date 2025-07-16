<?php

namespace App\Models;

use App\Models\Sistem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spt extends Model
{
    protected $guarded = ['id'];

    public function pic()
    {
        return $this->belongsTo(Sistem::class, 'pic_id');
    }

    public function spt_ppn()
    {
        return $this->hasOne(SptPpn::class);
    }

    public function spt_pph()
    {
        return $this->hasOne(SptPph::class);
    }

    public function spt_unifikasi()
    {
        return $this->hasOne(SptUnifikasi::class);
    }

    public function sistem(): BelongsTo
    {
        return $this->belongsTo(Sistem::class, 'badan_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
}

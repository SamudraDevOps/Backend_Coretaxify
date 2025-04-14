<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faktur extends Model
{
    protected $guarded = ['id'];

    public function detail_transaksis()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function akun_pengirim() {
        return $this->belongsTo(Sistem::class, 'akun_pengirim_id');
    }

    public function akun_penerima() {
        return $this->belongsTo(Sistem::class, 'akun_penerima_id');
    }
}
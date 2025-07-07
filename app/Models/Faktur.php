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

    public function pic() {
        return $this->belongsTo(Sistem::class, 'pic_id');
    }

    public function akun_pengirim() {
        return $this->belongsTo(Sistem::class, 'akun_pengirim_id');
    }

    public function akun_penerima() {
        return $this->belongsTo(Sistem::class, 'akun_penerima_id');
    }

    public function akun_penerima_tambahan() {
        return $this->belongsTo(SistemTambahan::class, 'akun_penerima_id');
    }

    public function getJumlahDppLainReturAttribute(): float
    {
        return $this->detail_transaksis()->sum('dpp_lain_retur') ?? 0;
    }

    public function getJumlahPpnReturAttribute(): float
    {
        return $this->detail_transaksis()->sum('ppn_retur') ?? 0;
    }

    public function getJumlahPpnbmReturAttribute(): float
    {
        return $this->detail_transaksis()->sum('ppnbm_retur') ?? 0;
    }

    public function getJumlahTotalHargaReturAttribute(): float
    {
        return $this->detail_transaksis()->sum('total_harga_diretur') ?? 0;
    }

    public function getJumlahPemotonganHargaReturAttribute(): float
    {
        return $this->detail_transaksis()->sum('pemotongan_harga_diretur') ?? 0;
    }
}
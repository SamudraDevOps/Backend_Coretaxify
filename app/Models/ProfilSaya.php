<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilSaya extends Model
{
    protected $guarded = ['id'];

    public function informasi_umum(): BelongsTo {
        return $this->belongsTo(InformasiUmum::class, 'informasi_umum_id');
    }

    public function data_ekonomi(): BelongsTo {
        return $this->belongsTo(DataEkonomi::class, 'data_ekonomi_id');
    }

    public function detail_kontaks() {
        return $this->hasMany(DetailKontak::class, 'sistem_id');
    }

    public function detail_kontak() {
        return $this->hasOne(DetailKontak::class, 'sistem_id');
    }

    public function tempat_kegiatan_usahas() {
        return $this->hasMany(TempatKegiatanUsaha::class, 'sistem_id');
    }

    public function unit_pajak_keluargas() {
        return $this->hasMany(UnitPajakKeluarga::class, 'sistem_id');
    }

    public function detail_banks() {
        return $this->hasMany(DetailBank::class,    'sistem_id');
    }

    public function pihak_terkaits() {
        return $this->hasMany(PihakTerkait::class, 'sistem_id');
    }

    public function nomor_identifikasi_eksternal() {
        return $this->belongsTo(NomorIdentifikasiEksternal::class);
    }

    public function sistem() {
        return $this->hasOne(Sistem::class);
    }
}
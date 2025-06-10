<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSaya extends Model
{
    protected $guarded = ['id'];

    public function informasi_umum() {
        return $this->belongsTo(InformasiUmum::class);
    }

    public function data_ekonomi() {
        return $this->belongsTo(DataEkonomi::class);
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
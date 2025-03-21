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
    public function tempat_kegiatan_usahas() {
        return $this->hasMany(TempatKegiatanUsaha::class, 'sistem_id');
    }

    public function unit_pajak_keluargas() {
        return $this->hasMany(UnitPajakKeluarga::class, 'sistem_id');
    }

    public function detail_banks() {
        return $this->hasMany(DetailBank::class,    'sistem_id');
    }

    public function penunjukkan_wajib_pajak_saya() {
        return $this->belongsTo(PenunjukkanWajibPajakSaya::class);
    }

    public function nomor_identifikasi_eksternal() {
        return $this->belongsTo(NomorIdentifikasiEksternal::class);
    }

    public function jenis_pajak() {
        return $this->belongsTo(JenisPajak::class);
    }

    public function objek_pajak_bumi_dan_bangunan() {
        return $this->belongsTo(ObjekPajakBumiDanBangunan::class);
    }


    public function pihak_terkait() {
        return $this->belongsTo(PihakTerkait::class);
    }

    public function portal_saya() {
        return $this->hasOne(PortalSaya::class);
    }
}

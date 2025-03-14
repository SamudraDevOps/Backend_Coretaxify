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

    public function detail_kontak() {
        return $this->belongsTo(DetailKontak::class);
    }

    public function detail_bank() {
        return $this->belongsTo(DetailBank::class);
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

    public function tempat_kegiatan_usaha() {
        return $this->belongsTo(TempatKegiatanUsaha::class);
    }

    public function pihak_terkait() {
        return $this->belongsTo(PihakTerkait::class);
    }

    public function portal_saya() {
        return $this->hasOne(PortalSaya::class);
    }
}

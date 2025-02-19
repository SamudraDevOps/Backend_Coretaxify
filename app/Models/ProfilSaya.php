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

    public function penunjukkan_wajib_pajak_saya() {
        return $this->belongsTo(PenunjukkanWajibPajakSaya::class);
    }

    public function alamat_wajib_pajak() {
        return $this->belongsTo(AlamatWajibPajak::class);
    }

    public function manajemen_kasus() {
        return $this->belongsTo(ManajemenKasus::class);
    }
    
    public function nomor_identitas_eksternal() {
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

    public function kode_klu() {
        return $this->belongsTo(KodeKlu::class);
    }
    
    public function pihak_terkait() {
        return $this->belongsTo(PihakTerkait::class);
    }   
}
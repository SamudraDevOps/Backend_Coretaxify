<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSaya extends Model
{
    protected $guarded = ['id'];

    public function informasi_umums() {
        return $this->hasOne(InformasiUmum::class);
    }

    public function data_ekonomis() {
        return $this->hasOne(DataEkonomi::class);
    }

    public function detail_kontaks() {
        return $this->hasOne(DetailKontak::class);
    }

    public function detail_banks() {
        return $this->hasOne(DetailBank::class);
    }

    public function penunjukkan_wajib_pajak_sayas() {
        return $this->hasOne(PenunjukkanWajibPajakSaya::class);
    }

    public function alamat_wajib_pajaks() {
        return $this->hasOne(AlamatWajibPajak::class);
    }

    public function manajemen_kasuses() {
        return $this->hasOne(ManajemenKasus::class);
    }
    
    public function nomor_identifikasi_eksternals() {
        return $this->hasOne(NomorIdentifikasiEksternal::class);
    }
    
    public function jenis_pajaks() {
        return $this->hasOne(JenisPajak::class);
    }
    
    public function objek_pajak_bumi_dan_bangunans() {
        return $this->hasOne(ObjekPajakBumiDanBangunan::class);
    }
    
    public function tempat_kegiatan_usahas() {
        return $this->hasOne(TempatKegiatanUsaha::class);
    }

    public function kode_klus() {
        return $this->hasOne(KodeKlu::class);
    }
    
    public function pihak_terkaits() {
        return $this->hasOne(PihakTerkait::class);
    }
       
    public function portal_saya() {
        return $this->belongsTo(PortalSaya::class); 
    }   
}
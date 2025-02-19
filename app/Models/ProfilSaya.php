<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilSaya extends Model
{
    protected $guarded = ['id'];

    public function informasi_umums() {
        return $this->hasMany(InformasiUmum::class);
    }

    public function data_ekonomis() {
        return $this->hasMany(DataEkonomi::class);
    }

    public function penunjukkan_wajib_pajak_sayas() {
        return $this->hasMany(PenunjukkanWajibPajakSaya::class);
    }

    public function alamat_wajib_pajaks() {
        return $this->hasMany(AlamatWajibPajak::class);
    }

    public function manajemen_kasuses() {
        return $this->hasMany(ManajemenKasus::class);
    }
    
    public function nomor_identitas_eksternals() {
        return $this->hasMany(NomorIdentifikasiEksternal::class);
    }
    
    public function jenis_pajaks() {
        return $this->hasMany(JenisPajak::class);
    }
    
    public function objek_pajak_bumi_dan_bangunans() {
        return $this->hasMany(ObjekPajakBumiDanBangunan::class);
    }
    
    public function tempat_kegiatan_usahas() {
        return $this->hasMany(TempatKegiatanUsaha::class);
    }

    public function kode_klus() {
        return $this->hasMany(KodeKlu::class);
    }
    
    public function pihak_terkaits() {
        return $this->hasMany(PihakTerkait::class);
    }
       
    public function portal_saya() {
        return $this->belongsTo(PihakTerkait::class);
    }   
}
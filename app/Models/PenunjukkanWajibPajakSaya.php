<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenunjukkanWajibPajakSaya extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
          
        'status_pemberian_akses_portal',
        'nama_wajib_pajak',
        'npwp',
        'nomor_penunjukkan',
        'status_penunjukkan',
        'tanggal_disetujui',
        'tanggal_ditolak',
        'tanggal_dicabut',
        'tanggal_dibatalkan',
        'alasan',
    ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }
}
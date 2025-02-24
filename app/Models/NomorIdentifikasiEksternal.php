<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorIdentifikasiEksternal extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
          
        'tipe_identifikasi_eksternal',
        'nomor_identifikasi',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }
}
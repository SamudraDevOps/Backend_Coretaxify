<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBank extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
          
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening_bank',
        'jenis_rekening_bank',
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_rekening-bank_utama',
    ];

    public function profil_saya()
    {
        return $this->belongsTo(ProfilSaya::class);
    }
}
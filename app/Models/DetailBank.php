<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailBank extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening_bank',
        'jenis_rekening_bank',
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir',
        'is_rekening-bank_utama',
    ];

    public function profil_sayas()
    {
        return $this->hasMany(ProfilSaya::class);
    }
}
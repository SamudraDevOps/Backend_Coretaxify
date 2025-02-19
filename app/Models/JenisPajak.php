<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPajak extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'jenis_pajak',
        'tanggal_permohonan',
        'tanggal_mulai_transaksi',
        'tanggal_pendaftaran',
        'tanggal_pencabutan_pendaftaran',
        'nomor_kasus',
    ];

    public function profil_sayas()
    {
        return $this->hasMany(ProfilSaya::class);
    }
}
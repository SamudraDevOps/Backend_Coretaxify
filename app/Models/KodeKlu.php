<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KodeKlu extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'kode_nama',
        'deskripsi_klu',
        'deskripsi_tku',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function profil_sayas()
    {
        return $this->hasMany(ProfilSaya::class);
    }
}
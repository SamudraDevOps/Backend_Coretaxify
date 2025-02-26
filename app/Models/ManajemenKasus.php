<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenKasus extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
          
        'kanal',
        'tanggal_permohonan',
    ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitPajakKeluarga extends Model
{
    protected $guarded = ['id'];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }
}

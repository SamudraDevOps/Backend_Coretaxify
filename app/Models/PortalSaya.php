<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalSaya extends Model
{
    protected $guarded = ['id'];

    public function sistem() {
        return $this->belongsTo(ProfilSaya::class);
    }
       
    public function profil_saya() {
        return $this->hasMany(ProfilSaya::class);
    }   
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PortalSaya extends Model
{
    protected $guarded = ['id'];

    public function sistem() {
        return $this->hasOne(Sistem::class);
    }
       
    public function profil_saya() {
        return $this->belongsTo(ProfilSaya::class);
    }   
}
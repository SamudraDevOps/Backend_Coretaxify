<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class PortalSaya extends Model
{
    protected $guarded = ['id'];

    public function sistem() {
        return $this->belongsTo(Sistem::class);
    }
       
    public function profil_sayas(): HasMany {
        return $this->hasMany(ProfilSaya::class);
    }   
}
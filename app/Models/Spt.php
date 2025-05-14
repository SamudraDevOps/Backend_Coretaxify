<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spt extends Model
{
    protected $guarded = ['id'];

    public function pics()
    {
        return $this->hasMany(Pic::class);
    }

    public function spt_ppn()
    {
        return $this->hasOne(SptPpn::class);
    }
}
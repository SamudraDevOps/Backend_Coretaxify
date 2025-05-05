<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bupot extends Model
{
    protected $guarded = ['id'];

    public function pembuat() {
        return $this->belongsTo(Sistem::class, 'pembuat_id');
    }

    public function representatif() {
        return $this->belongsTo(Sistem::class, 'representatif_id');
    }

    public function dokumen_bupot() {
        return $this->hasMany(BupotDokumen::class);
    }

}

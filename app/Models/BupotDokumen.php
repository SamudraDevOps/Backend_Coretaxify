<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BupotDokumen extends Model
{
    protected $guarded = ['id'];

    public function bupot() {
        return $this->belongsTo(Bupot::class);
    }
}

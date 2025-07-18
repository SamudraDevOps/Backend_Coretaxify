<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BupotScore extends Model
{
    protected $guarded = ['id'];

    public function sistem() {
        return $this->belongsTo(Sistem::class);
    }
}

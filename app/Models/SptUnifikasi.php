<?php

namespace App\Models;

use App\Models\Spt;
use Illuminate\Database\Eloquent\Model;

class SptUnifikasi extends Model
{
    protected $guarded = ['id'];

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }
}

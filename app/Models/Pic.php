<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    protected $guarded = ['id'];

    public function akun_op() {
        return $this->belongsTo(Sistem::class, 'akun_op_id');
    }

    public function akun_badan() {
        return $this->belongsTo(Sistem::class, 'akun_badan_id');
    }
}
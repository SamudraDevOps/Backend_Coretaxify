<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ['id'];

    public function pembuat() {
        return $this->belongsTo(Sistem::class, 'pembuat_id');
    }
}
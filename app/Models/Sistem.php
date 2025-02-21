<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sistem extends Model
{
    protected $guarded = ['id'];

    public function portal_saya() {
        return $this->hasMany(PortalSaya::class);
    }

    public function assignment_users() {
        return $this->belongsTo(AssignmentUser::class);
    }
}
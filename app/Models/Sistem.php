<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sistem extends Model
{
    protected $guarded = ['id'];

    public function portal_saya() {
        return $this->belongsTo(PortalSaya::class);
    }

    public function assignment_user(): BelongsTo {
        return $this->belongsTo(AssignmentUser::class);
    }

    public function akun_ops() {
        return $this->hasMany(Pic::class, 'akun_op_id');
    }

    public function akun_badans() {
        return $this->hasMany(Pic::class, 'akun_badan_id');
    }
}
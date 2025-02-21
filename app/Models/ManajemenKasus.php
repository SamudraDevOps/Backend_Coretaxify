<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManajemenKasus extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'kanal',
        'tanggal_permohonan',
    ];

    public function profil_saya()
    {
        return $this->belongsTo(ProfilSaya::class);
    }
}
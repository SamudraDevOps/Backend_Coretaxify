<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PihakTerkait extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'tipe_pihak_terkait',
        'is_pic',
        'jenis_orang_terkait',
        'npwp',
        'nomor_paspor',
        'kewarganegaraan',
        'negara_asal',
        'email',
        'nomor_handphone',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function assignment_users()
    {
        return $this->hasMany(AssignmentUser::class);
    }



}
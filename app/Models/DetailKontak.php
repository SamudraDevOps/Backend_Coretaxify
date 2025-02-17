<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKontak extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'jenis_kontak',
        'nomor_telepon',
        'nomor_handphone',
        'nomor_faksimile',
        'alamat_email',
        'alamat_situs_wajib',
        'keterangan',
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
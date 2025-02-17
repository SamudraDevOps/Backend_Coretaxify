<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KuasaWajibPajak extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'is_wajib_pajak',
        'id_penunjukkan_perwakilan',
        'nama_wakil',
        'jenis_perwakilan',
        'id_penunjukkan_perwakilan',
        'nomor_dokumen_penujukkan_perwakilan',
        'izin_perwakilan',
        'status_penujukkan',
        'tanggal_disetujui',
        'tanggal_ditolak',
        'tanggal_dicabut',
        'tanggal_dibatalkan',
        'tanggal_tertunda',
        'alasan',
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatWajibPajak extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'negara',
        'jenis_alamat',
        'detail_alamat',
        'is_lokasi_disewa',
        'npwp_pemilik_tempat_sewa',
        'nama_pemilik_tempat_sewa',
        'tanggal_mulai_sewa',
        'tanggal_berakhir_sewa',
        'tanggal_mulai',
        'tanggal_berakhir',
        'kode_kpp',
        'kpp',
        'seksi_pengawasan',
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
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiUmum extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'npwp',
        'jenis_wajib_pajak',
        'nama',
        'kategori_wajib_pajak',
        'negara_asal',
        'tanggal_keputusan_pengesahan',
        'nomor_keputusan_pengesahan_perubahan',
        'tanggal_surat_keputusan_pengesahan_perubahan',
        'dead_of_establishment_document_number',
        'place_of_establishment',
        'tanggal_pendirian',
        'notary_officer_nik',
        'notary_officer_name',
        'jenis_perusahaan',
        'authorized_capital',
        'issued_capital',
        'paid_in_capital',
        'kewarganegaraan',
        'bahasa',
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
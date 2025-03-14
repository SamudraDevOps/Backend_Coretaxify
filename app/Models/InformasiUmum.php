<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class InformasiUmum extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
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
        'modal_dasar',
        'modal_ditempatkan',
        'modal_disetor',
        'kewarganegaraan',
        'bahasa',
    ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }
}

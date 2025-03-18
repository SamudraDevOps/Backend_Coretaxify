<?php

namespace App\Models;

use App\Http\Requests\ProfilSaya\StoreProfilSayaRequest;
use Illuminate\Database\Eloquent\Model;

class TempatKegiatanUsaha extends Model
{
    protected $guarded = ['id'];

    // protected $fillable = [

    //     'nitku',
    //     'jenis_tku',
    //     'nama_tku',
    //     'deskripsi_tku',
    //     'nama_klu',
    //     'deskripsi_klu_tku',
    //     'tambah_pic_tku_id',
    //     'jenis_alamat',
    //     'detail_alamat',
    //     'rt',
    //     'rw',
    //     'provinsi',
    //     'kota_kabupaten',
    //     'kecamatan',
    //     'kelurahan_desa',
    //     'kode_pos',
    //     'data_geometri',
    //     'seksi_pengawasan',
    //     'is_lokasi_yang_disewa',
    //     'tanggal_mulai',
    //     'tanggal_berakhir',
    //     'is_toko_retail',
    //     'is_kawasan_bebas',
    //     'is_kawasan_ekonomi_khusus',
    //     'is_kawasan_perimbunan_berikat',
    //     'nomor_surat_keputusan',
    //     'decree_number_data_valid_from',
    //     'decree_number_data_valid_to',
    //     'kode_kpp',
    //     'is_alamat_utama_pkp',
    // ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }



}

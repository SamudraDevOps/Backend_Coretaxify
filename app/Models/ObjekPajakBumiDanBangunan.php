<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjekPajakBumiDanBangunan extends Model
{
    protected $guarded = ['id'];    

    protected $fillable = [
        'account_id',
        'assignment_users_id',
        'nop',
        'nama_objek_pajak',
        'sektor',
        'jenis',
        'tipe_bumi',
        'rincian',
        'status_kegiatan',
        'instansi_pemberi_izin',
        'luas_objek_pajak',
        'nomor_induk_induk_berusaha',
        'nomor_ijin_objek',
        'tanggal_ijin_objek',
        'detail_alamat',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'kelurahan_desa',
        'kode_wilayah',
        'kode_pos',
        'data_geometri',
        'tanggal_pendaftaran',
        'tanggal_pencabutan_pendaftaran',
        'kode_kpp',
        'seksi_pengawasan',
    ];

    public function profil_sayas()
    {
        return $this->hasMany(ProfilSaya::class);
    }
}
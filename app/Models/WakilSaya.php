<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WakilSaya extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
        'nama',
        'npwp',
        'jenis_perwakilan',
        'id_penunjukkan_perwakilan',
        'nomor_dokumen_penunjukkan_perwakilan',
        'izin_perwakilan',
        'status_penujukkan',
        'tanggal_disetujui',
        'tanggal_ditolak',
        'tanggal_dicabut',
        'tanggal_dibatalkan',
        'alasan',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];  
}
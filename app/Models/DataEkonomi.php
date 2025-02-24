<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEkonomi extends Model
{
    protected $guarded = ['id'];

    protected $fillable = [
          
        'merek_dagang',
        'is_karyawan',
        'jumlah_karyawan',
        'metode_pembukuan',
        'mata_uang_pembukuan',
        'periode_pembukuan',
        'omset_per_tahun',
        'jumlah_peredaran_bruto',
    ];

    public function profil_saya()
    {
        return $this->belongsTo(ProfilSaya::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BupotObjekPajak extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe_bupot',
        'nama_objek_pajak',
        'jenis_pajak',
        'kode_objek_pajak',
        'tarif_pajak',
        'sifat_pajak_penghasilan',
    ];
}

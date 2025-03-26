<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PihakTerkait extends Model
{
    protected $guarded = ['id'];

    // protected $fillable = [
    //     'nama_pengurus',
    //     'npwp',
    //     'tipe_pihak_terkait',
    //     'jenis_orang_terkait',
    //     'sub_orang_terkait',
    //     'kewarganegaraan',
    //     'negara_asal',
    //     'email',
    //     'tanggal_mulai',
    //     'tanggal_berakhir',
    // ];

    public function profil_saya()
    {
        return $this->hasOne(ProfilSaya::class);
    }

    public function sistem()
    {
        return $this->belongsTo(Sistem::class, 'akun_op');
    }

}

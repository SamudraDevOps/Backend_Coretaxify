<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sistem extends Model
{
    protected $guarded = ['id'];

    public function profil_saya(): BelongsTo {
        return $this->belongsTo(ProfilSaya::class, 'profil_saya_id');
    }

    public function assignment_user(): BelongsTo {
        return $this->belongsTo(AssignmentUser::class);
    }

    public function akun_ops() {
        return $this->hasMany(PihakTerkait::class, 'akun_op');
    }
    // public function akun_ops() {
    //     return $this->hasMany(Pic::class, 'akun_op_id');
    // }

    public function akun_badans() {
        return $this->hasMany(Pic::class, 'akun_badan_id');
    }

    public function detail_kontaks() {
        return $this->hasMany(DetailKontak::class);
    }

    public function tempat_kegiatan_usahas() {
        return $this->hasMany(TempatKegiatanUsaha::class);

    }
    public function detail_banks() {
        return $this->hasMany(TempatKegiatanUsaha::class);
    }

    public function unit_pajak_keluargas() {
        return $this->hasMany(UnitPajakKeluarga::class);
    }

    public function pihak_terkaits() {
        return $this->hasMany(PihakTerkait::class, );
    }

    public function sistem_tambahans() {
        return $this->hasMany(SistemTambahan::class, );
    }

    public function bupot_scores() {
        return $this->hasMany(BupotScore::class);
    }

    public function faktur_scores() {
        return $this->hasMany(FakturScore::class);
    }

    public function spt_scores() {
        return $this->hasMany(SptScore::class);
    }
}

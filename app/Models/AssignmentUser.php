<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AssignmentUser extends Model
{
    /** @use HasFactory<\Database\Factories\AssignmentUserFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function alamat_wajib_pajak(): BelongsTo {
        return $this->belongsTo(AlamatWajibPajak::class);
    }
    
    public function data_ekonomi(): BelongsTo {
        return $this->belongsTo(DataEkonomi::class);
    }

    public function detail_bank(): BelongsTo {
        return $this->belongsTo(DetailBank::class);
    }

    public function detail_kontak(): BelongsTo {
        return $this->belongsTo(DetailKontak::class);
    }

    public function informasi_umum(): BelongsTo {
        return $this->belongsTo(InformasiUmum::class);
    }

    public function jenis_pajak(): BelongsTo {
        return $this->belongsTo(JenisPajak::class);
    }

    public function kode_klu(): BelongsTo {
        return $this->belongsTo(KodeKlu::class);
    }

    public function kuasa_wajib_pajak(): BelongsTo {
        return $this->belongsTo(KuasaWajibPajak::class);
    }

    public function manajemen_kasus(): BelongsTo {
        return $this->belongsTo(ManajemenKasus::class);
    }
    
    public function nomor_identifikasi_eksternal(): BelongsTo {
        return $this->belongsTo(NomorIdentifikasiEksternal::class);
    }

    public function objek_pajak_bumi_dan_bangunan(): BelongsTo {
        return $this->belongsTo(ObjekPajakBumiDanBangunan::class);
    }

    public function penunjukkan_wajib_pajak_saya(): BelongsTo {
        return $this->belongsTo(PenunjukkanWajibPajakSaya::class);
    }
    
    public function pihak_terkait(): BelongsTo {
        return $this->belongsTo(PihakTerkait::class);
    }

    public function tempat_kegiatan_usaha(): BelongsTo {
        return $this->belongsTo(TempatKegiatanUsaha::class);
    }
}
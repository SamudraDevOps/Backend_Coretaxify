<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    /** @use HasFactory<\Database\Factories\AccountFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'task_id',
        'account_type_id',
        'exam_id',
        'group_id',
        'nama',
        'npwp',
        'kegiatan_utama',
        'jenis_wajib_pajak',
        'kategori_wajib_pajak',
        'status_npwp',
        'tanggal_terdaftar',
        'tanggal_aktivasi',
        'status_pengusaha_kena_pajak',
        'tanggal_pengukuhan_pkp',
        'kantor_wilayah_direktorat_jenderal_pajak',
        'kantor_pelayanan_pajak',
        'seksi_pengawasan',
        'tanggal_pembaruan_profil_terakhir',
        'alamat_utama',
        'nomor_handphone',
        'email',
        'kode_klasifikasi_lapangan_usaha',
        'deskripsi_klasifikasi_lapangan_usaha',
    ];

    public function task(): BelongsTo {
        return $this->belongsTo(Task::class);
    }

    public function account_type(): BelongsTo {
        return $this->belongsTo(AccountType::class);
    }
    
    public function exam(): BelongsTo {
        return $this->belongsTo(Exam::class);
    }
    
    public function group(): BelongsTo {
        return $this->belongsTo(Group::class);
    }
    
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
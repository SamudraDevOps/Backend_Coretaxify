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
        // 'exam_id',
        // 'group_id',
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
    // public function exam(): BelongsTo {
    //     return $this->belongsTo(Exam::class);
    // }
    // public function group(): BelongsTo {
    //     return $this->belongsTo(Group::class);
    // }
}

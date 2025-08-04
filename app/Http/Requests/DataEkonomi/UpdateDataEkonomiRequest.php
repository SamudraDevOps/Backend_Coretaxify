<?php

namespace App\Http\Requests\DataEkonomi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataEkonomiRequest extends FormRequest {
    public function rules(): array {
        return [
            'sumber_penghasilan' => 'nullable|string',
            'izin_usaha' => 'nullable|string',
            'tanggal_izin_usaha' => 'nullable|date',
            'tempat_kerja' => 'nullable|string',
            'penghasilan_per_bulan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'jumlah_karyawan' => 'nullable|string',
            'deskripsi_kegiatan' => 'nullable|string',
            'periode_pembukuan' => 'nullable|string',
            'peredaran_bruto' => 'nullable|string',
            'metode_pembukuan' => 'nullable|string',
            'mata_uang_pembukuan' => 'nullable|string',
            'merek_dagang' => 'nullable|string',
            'omset_per_tahun' => 'nullable|string',
            'jumlah_peredaran_bruto' => 'nullable|string',
        ];
    }
}

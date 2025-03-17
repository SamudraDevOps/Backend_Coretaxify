<?php

namespace App\Http\Requests\InformasiUmum;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformasiUmumRequest extends FormRequest {
    public function rules(): array {
        return [
            'negara_asal' => 'nullable|string',
            'tanggal_keputusan_pengesahan' => 'nullable|date',
            'nomor_keputusan_pengesahan_perubahan' => 'nullable|string',
            'tanggal_surat_keputusasan_pengesahan_perubahan' => 'nullable|date',
            'nomor_keputusasan_pengesahan_perubahan' => 'nullable|string',
            'nomor_akta_pendirian' => 'nullable|string',
            'tanggal_pendirian' => 'nullable|date',
            'tempat_pendirian' => 'nullable|string',
            'nik_notaris' => 'nullable|string',
            'nama_notaris' => 'nullable|string',
            'jenis_perusahaan' => 'nullable|string',
            'modal_dasar' => 'nullable|integer',
        'modal_ditempatkan' => 'nullable|string',
            'modal_disetor' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'bahasa' => 'nullable|string',
            'nomor_paspor' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'status_perkawinan' => 'nullable|string',
            'status_hubungan_keluarga' => 'nullable|string',
            'agama' => 'nullable|string',
            'jenis_pekerjaan' => 'nullable|string',
            'nama_ibu_kandung' => 'nullable|string',
            'nomor_kartu_keluarga' => 'nullable|string',
        ];
    }
}

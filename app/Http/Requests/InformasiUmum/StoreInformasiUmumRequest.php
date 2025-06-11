<?php

namespace App\Http\Requests\InformasiUmum;

use Illuminate\Foundation\Http\FormRequest;

class StoreInformasiUmumRequest extends FormRequest {
    public function rules(): array {
        return [

            'npwp' => 'nullable|string',
            'jenis_wajib_pajak' => 'nullable|string',
            'nama' => 'nullable|string',
            'kategori_wajib_pajak' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'tanggal_keputusan_pengesahan' => 'nullable|date',
            'nomor_keputusan_pengesahan' => 'nullable|string',
            'nomor_keputusan_pengesahan_perubahan' => 'nullable|string',
            'tanggal_surat_keputusasan_pengesahan_perubahan' => 'nullable|date',
            'dead_of_establishment_document_number' => 'nullable|string',
            'place_of_establishment' => 'nullable|string',
            'tanggal_pendirian' => 'nullable|date',
            'nik_notaris' => 'nullable|string',
            'nama_notaris' => 'nullable|string',
            'jenis_perusahaan' => 'nullable|string',
            'modal_dasar' => 'nullable|integer',
            'modal_ditempatkan' => 'nullable|string',
            'modal_disetor' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'bahasa' => 'nullable|string',
        ];
    }
}

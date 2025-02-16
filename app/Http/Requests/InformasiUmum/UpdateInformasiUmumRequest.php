<?php

namespace App\Http\Requests\InformasiUmum;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformasiUmumRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'npwp' => 'nullable|string',
            'jenis_wajib_pajak' => 'nullable|string',
            'nama' => 'nullable|string',
            'kategori_wajib_pajak' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'tanggal_keputusan_pengesahan' => 'nullable|date',
            'nomor_keputusan_pengesahan_perubahan' => 'nullable|string',
            'tanggal_surat_keputusasan_pengesahan_perubahan' => 'nullable|date',
            'dead_of_establishment_document_number' => 'nullable|string',
            'place_of_establishment' => 'nullable|string',
            'tanggal_pendirian' => 'nullable|date',
            'notary_office_nik' => 'nullable|string',
            'notary_office_name' => 'nullable|string',
            'jenis_perusahaan' => 'nullable|string',
            'authorized_capital' => 'nullable|integer',
            'issued_capital' => 'nullable|string',
            'paid_in_capital' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'bahasa' => 'nullable|string',
        ];
    }
}
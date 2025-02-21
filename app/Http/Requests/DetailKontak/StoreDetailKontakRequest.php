<?php

namespace App\Http\Requests\DetailKontak;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailKontakRequest extends FormRequest {
    public function rules(): array {
        return [
             
            'jenis_kontak' => 'nullable|string',
            'nomor_telpon' => 'nullable|string',
            'nomor_handphone' => 'nullable|string',
            'nomor_faksimile' => 'nullable|string',
            'alamat_email' => 'nullable|string',
            'alamat_situs_wajib' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date|after:start_time',
        ];
    }
}
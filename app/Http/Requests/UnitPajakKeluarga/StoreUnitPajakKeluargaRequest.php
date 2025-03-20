<?php

namespace App\Http\Requests\UnitPajakKeluarga;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitPajakKeluargaRequest extends FormRequest {
    public function rules(): array {
        return [
            'nik_anggota_keluarga' => 'nullable|string',
            'jenis_kelamin' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'nomor_kartu_keluarga' => 'nullable|string',
            'nama_anggota_keluarga' => 'nullable|string',
            'status_hubungan_keluarga' => 'nullable|string',
            'pekerjaan' => 'nullable|string',
            'status_unit_perpajakan' => 'nullable|string',
            'status_ptkp' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}

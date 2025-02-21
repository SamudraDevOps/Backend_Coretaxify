<?php

namespace App\Http\Requests\NomorIdentifikasiEksternal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNomorIdentifikasiEksternalRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id',
            'tipe_nomor_identifikasi' => 'nullable|string',
            'nomor_identifikasi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
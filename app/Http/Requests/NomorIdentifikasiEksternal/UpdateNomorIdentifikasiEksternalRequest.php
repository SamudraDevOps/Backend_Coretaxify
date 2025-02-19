<?php

namespace App\Http\Requests\NomorIdentifikasiEksternal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNomorIdentifikasiEksternalRequest extends FormRequest {
    public function rules(): array {
        return [
            'tipe_nomor_identifikasi' => 'nullable|string',
            'nomor_identifikasi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
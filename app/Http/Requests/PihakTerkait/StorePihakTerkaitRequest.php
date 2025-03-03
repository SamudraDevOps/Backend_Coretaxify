<?php

namespace App\Http\Requests\PihakTerkait;

use Illuminate\Foundation\Http\FormRequest;

class StorePihakTerkaitRequest extends FormRequest {
    public function rules(): array {
        return [
            'nama_pengurus' => 'nullable|string',
            'npwp' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'sub_orang_terkait' => 'nullable|string',
            'email' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
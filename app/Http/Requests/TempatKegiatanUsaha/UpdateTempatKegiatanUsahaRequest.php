<?php

namespace App\Http\Requests\TempatKegiatanUsaha;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTempatKegiatanUsahaRequest extends FormRequest {
    public function rules(): array {
        return [
            'nitku' => 'nullable|string',
            'jenis_tku' => 'nullable|string',
            'jenis_usaha' => 'nullable|string',
            'nama_tku' => 'nullable|string',
        ];
    }
}
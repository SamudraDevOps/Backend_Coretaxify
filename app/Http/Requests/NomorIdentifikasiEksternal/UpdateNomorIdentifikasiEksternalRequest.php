<?php

namespace App\Http\Requests\NomorIdentifikasiEksternal;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNomorIdentifikasiEksternalRequest extends FormRequest {
    public function rules(): array {
        return [
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}

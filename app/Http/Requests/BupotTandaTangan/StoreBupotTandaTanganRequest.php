<?php

namespace App\Http\Requests\BupotTandaTangan;

use Illuminate\Foundation\Http\FormRequest;

class StoreBupotTandaTanganRequest extends FormRequest {
    public function rules(): array {
        return [
            'jenis_penandatanganan' => 'required|string|max:255',
            'penyedia_penandatangan' => 'required|string|max:255',
            'id_penandatangan' => 'required|string|max:255',
            'katasandi_penandatangan' => 'required|string|max:255',
        ];
    }
}

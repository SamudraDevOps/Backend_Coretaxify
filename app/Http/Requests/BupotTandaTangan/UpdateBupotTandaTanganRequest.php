<?php

namespace App\Http\Requests\BupotTandaTangan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBupotTandaTanganRequest extends FormRequest {
    public function rules(): array {
        return [
            'jenis_penandatanganan' => 'sometimes|string|max:255',
            'penyedia_penandatangan' => 'sometimes|string|max:255',
            'id_penandatangan' => 'sometimes|string|max:255',
            'katasandi_penandatangan' => 'sometimes|string|max:255',
        ];
    }
}

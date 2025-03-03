<?php

namespace App\Http\Requests\WakilSayaInformasiUmum;

use Illuminate\Foundation\Http\FormRequest;

class StoreWakilSayaInformasiUmumRequest extends FormRequest {
    public function rules(): array {
        return [
            'wakil_saya_id' => 'required|integer',
            'informasi_umum_id' => 'required|integer',
        ];
    }
}
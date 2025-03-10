<?php

namespace App\Http\Requests\Sistem;

use Illuminate\Foundation\Http\FormRequest;

class StoreSistemRequest extends FormRequest {
    public function rules(): array {
        return [
            // 'nama_akun' => 'nullable|string',
            // 'npwp_akun' => 'nullable|string',
            'assignment' => 'required|string'
        ];
    }
}
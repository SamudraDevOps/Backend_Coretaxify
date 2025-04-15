<?php

namespace App\Http\Requests\SistemTambahan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSistemTambahanRequest extends FormRequest {
    public function rules(): array {
        return [
            'nama_akun' => 'nullable|string|max:255',
            'npwp_akun' => 'nullable|string|max:255',
            'tipe_akun' => 'nullable|string|max:255',
            'alamat_utama_akun' => 'nullable|string|max:255',
            'email_akun' => 'nullable|email|max:255',
        ];
    }
}

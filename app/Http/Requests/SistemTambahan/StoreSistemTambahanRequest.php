<?php

namespace App\Http\Requests\SistemTambahan;

use Illuminate\Foundation\Http\FormRequest;

class StoreSistemTambahanRequest extends FormRequest {
    public function rules(): array {
        return [
            'sistem_id' => 'nullable|exists:sistems,id',
            'nama_akun' => 'nullable|string|max:255',
            'npwp_akun' => 'nullable|string|max:255',
            'tipe_akun' => 'nullable|string|max:255',
            'alamat_utama_akun' => 'nullable|string|max:255',
            'email_akun' => 'nullable|email|max:255',
        ];
    }
}

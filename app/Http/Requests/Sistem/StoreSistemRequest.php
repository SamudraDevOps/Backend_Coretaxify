<?php

namespace App\Http\Requests\Sistem;

use Illuminate\Foundation\Http\FormRequest;

class StoreSistemRequest extends FormRequest {
    public function rules(): array {
        return [
            'nama_akun' => 'required|string',
            'npwp_akun' => 'required|string',
            'assignment_user_id' => 'nullable|exists:assignment_users,id'
        ];
    }
}
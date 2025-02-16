<?php

namespace App\Http\Requests\KodeKlu;

use Illuminate\Foundation\Http\FormRequest;

class StoreKodeKluRequest extends FormRequest {
    public function rules(): array {
        return [
           'account_id' => 'nullable|exists:accounts,id',
           'assignment_users_id' => 'nullable|exists:assignment_users,id',
           'kode_nama' => 'nullable|string',
           'deskripsi_klu' => 'nullable|string',
           'deskripsi_tku' => 'nullable|string',
           'tanggal_mulai' => 'nullable|date',
           'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
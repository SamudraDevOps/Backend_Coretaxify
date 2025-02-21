<?php

namespace App\Http\Requests\KodeKlu;

use Illuminate\Foundation\Http\FormRequest;

class StoreKodeKluRequest extends FormRequest {
    public function rules(): array {
        return [
           'profil_saya_id' => 'nullable|exists:profil_sayas,id',
           'kode_nama' => 'nullable|string',
           'deskripsi_klu' => 'nullable|string',
           'deskripsi_tku' => 'nullable|string',
           'tanggal_mulai' => 'nullable|date',
           'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
<?php

namespace App\Http\Requests\KodeKlu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKodeKluRequest extends FormRequest {
    public function rules(): array {
        return [
             
            'kode_nama' => 'nullable|string',
            'deskripsi_klu' => 'nullable|string',
            'deskripsi_tku' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
         ];
    }
}
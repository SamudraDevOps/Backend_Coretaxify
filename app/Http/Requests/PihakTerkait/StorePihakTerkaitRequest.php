<?php

namespace App\Http\Requests\PihakTerkait;

use Illuminate\Foundation\Http\FormRequest;

class StorePihakTerkaitRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'tipe_pihak_terkait' => 'nullable|string',
            'is_pic' => 'nullable|boolean',
            'jenis_orang_terkait' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nomor_paspor' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'email' => 'nullable|string',
            'nomor_handphone' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}
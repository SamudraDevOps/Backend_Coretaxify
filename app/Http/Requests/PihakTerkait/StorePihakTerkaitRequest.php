<?php

namespace App\Http\Requests\PihakTerkait;

use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StorePihakTerkaitRequest extends FormRequest {
    public function rules(): array {
        return [
            'akun_op' => 'required|string',
            'kewarganegaraan' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'sub_orang_terkait' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}

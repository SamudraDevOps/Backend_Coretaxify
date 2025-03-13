<?php

namespace App\Http\Requests\PihakTerkait;

use App\Support\Enums\IntentEnum;
use Illuminate\Foundation\Http\FormRequest;

class StorePihakTerkaitRequest extends FormRequest {
    public function rules(): array {
        // $intent = $this->get('intent');

        // switch ($intent) {
        //     case IntentEnum::API_CREATE_PIHAK_TERKAIT->value:
        //         return [
        //             'akun_id' => 'required|string',
        //             'assignment_id' => 'required|exists:assignments,id',
        //             'sistem_id' => 'required|exists:sistems,id',
        //             'nama_pengurus' => 'required|string',
        //             'npwp' => 'required|string',
        //             'kewarganegaraan' => 'required|string',
        //             'negara_asal' => 'required|string',
        //             'sub_orang_terkait' => 'required|string',
        //             'email' => 'required|string',
        //             'keterangan' => 'required|string',
        //             'tanggal_mulai' => 'required|date',
        //             'tanggal_berakhir' => 'required|date',
        //         ];
        // }

        return [
            'akun_id' => 'required|string',
            'nama_pengurus' => 'nullable|string',
            'npwp' => 'nullable|string',
            'kewarganegaraan' => 'nullable|string',
            'negara_asal' => 'nullable|string',
            'sub_orang_terkait' => 'nullable|string',
            'email' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
        ];
    }
}

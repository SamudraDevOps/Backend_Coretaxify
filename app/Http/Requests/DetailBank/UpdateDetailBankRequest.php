<?php

namespace App\Http\Requests\DetailBank;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailBankRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id',
            "nama_bank" => "nullable|string",
            "nomor_rekening_bank" => "nullable|string",
            "jenis_rekening_bank" => "nullable|string",
            "keterangan" => "nullable|string",
            "tanggal_mulai" => "nullable|date",
            "tanggal_berakhir" => "nullable|date",
            "is_rekening_bank_utama" => "nullable|boolean"
        ];
    }
}
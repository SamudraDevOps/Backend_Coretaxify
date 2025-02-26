<?php

namespace App\Http\Requests\DetailBank;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailBankRequest extends FormRequest {
    public function rules(): array {
        return [
             
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
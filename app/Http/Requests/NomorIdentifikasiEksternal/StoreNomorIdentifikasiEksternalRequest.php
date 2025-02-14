<?php

namespace App\Http\Requests\NomorIdentifikasiEksternal;

use Illuminate\Foundation\Http\FormRequest;

class StoreNomorIdentifikasiEksternalRequest extends FormRequest {
    public function rules(): array {
        return [
            "account_id" => "nullable|exists:accounts,id",
            "assignment_users_id" => "nullable|exists:assignment_users,id",
            "tipe_nomor_identifikasi" => "nullable|string",
            "nomor_identifikasi" => "nullable|string",
            "tanggal_mulai" => "nullable|date",
            "tanggal_berakhir" => "nullable|date",
        ];
    }
}
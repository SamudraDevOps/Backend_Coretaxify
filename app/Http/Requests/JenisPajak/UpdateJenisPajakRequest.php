<?php

namespace App\Http\Requests\JenisPajak;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisPajakRequest extends FormRequest {
    public function rules(): array {
        return [
             
            'jenis_pajak' => 'nullable|string',
            'tanggal_permohonan' => 'nullable|date',
            'tanggal_mulai_transaksi' => 'nullable|date',
            'tanggal_pendaftaran' => 'nullable|date',
            'tanggal_pencabutan_pendaftaran' => 'nullable|date',
            'nomor_kasus' => 'nullable|integer',
        ];
    }
}
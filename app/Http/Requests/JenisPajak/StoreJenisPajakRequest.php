<?php

namespace App\Http\Requests\JenisPajak;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisPajakRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id', 
            'jenis_pajak' => 'nullable|string',
            'tanggal_permohonan' => 'nullable|date',
            'tanggal_mulai_transaksi' => 'nullable|date',
            'tanggal_pendaftaran' => 'nullable|date',
            'tanggal_pencabutan_pendaftaran' => 'nullable|date',
            'nomor_kasus' => 'nullable|integer',
        ];
    }
}
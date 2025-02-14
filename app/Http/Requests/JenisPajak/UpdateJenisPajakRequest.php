<?php

namespace App\Http\Requests\JenisPajak;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJenisPajakRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'jenis_pajak' => 'nullable|string',
            'tanggal_permohonan' => 'nullable|date',
            'tanggal_mulai_transaksi' => 'nullable|date',
            'tanggal_pendaftaran' => 'nullable|date',
            'tanggal_pencabutan_pendaftaran' => 'nullable|date',
            'nomor_kasus' => 'nullable|integer',
        ];
    }
}
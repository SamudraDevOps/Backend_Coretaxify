<?php

namespace App\Http\Requests\PenunjukkanWajibPajakSaya;

use Illuminate\Foundation\Http\FormRequest;

class StorePenunjukkanWajibPajakSayaRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'status_pemberian_akses_portal' => 'nullable|string',
            'nama_wajib_pajak' => 'nullable|string',
            'npwp' => 'nullable|string',
            'nomor_penunjukkan' => 'nullable|string',
            'status_penunjukkan' => 'nullable|string',
            'tanggal_disetujui' => 'nullable|date',
            'tanggal_ditolak' => 'nullable|date',
            'tanggal_dicabut' => 'nullable|date',
            'tanggal_dibatalkan' => 'nullable|date',
            'alasan' => 'nullable|string',
        ];
    }
}
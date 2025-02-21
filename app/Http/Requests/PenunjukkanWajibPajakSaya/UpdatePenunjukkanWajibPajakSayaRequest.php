<?php

namespace App\Http\Requests\PenunjukkanWajibPajakSaya;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenunjukkanWajibPajakSayaRequest extends FormRequest {
    public function rules(): array {
        return [
            'profil_saya_id' => 'nullable|exists:profil_sayas,id', 
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
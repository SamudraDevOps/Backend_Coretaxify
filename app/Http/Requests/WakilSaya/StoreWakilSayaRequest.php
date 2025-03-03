<?php

namespace App\Http\Requests\WakilSaya;

use Illuminate\Foundation\Http\FormRequest;

class StoreWakilSayaRequest extends FormRequest {
    public function rules(): array {
        return [
            'nama' => 'nullable|string',
            'npwp' => 'nullable|string',
            'jenis_perwakilan' => 'nullable|string',
            'id_penunjukkan_perwakilan' => 'nullable|string',
            'nomor_dokumen_penunjukkan_perwakilan' => 'nullable|string',
            'izin_perwakilan' => 'nullable|string',
            'status_penujukkan' => 'nullable|string',
            'tanggal_disetujui' => 'nullable|date',
            'tanggal_ditolak' => 'nullable|date',
            'tanggal_dicabut' => 'nullable|date',
            'tanggal_dibatalkan' => 'nullable|date',
            'alasan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',             
        ];
    }
}
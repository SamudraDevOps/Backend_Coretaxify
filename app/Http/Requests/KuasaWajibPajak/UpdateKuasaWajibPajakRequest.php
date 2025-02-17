<?php

namespace App\Http\Requests\KuasaWajibPajak;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKuasaWajibPajakRequest extends FormRequest {
    public function rules(): array {
        return [
            'account_id' => 'nullable|exists:accounts,id',
            'assignment_users_id' => 'nullable|exists:assignment_users,id',
            'is_wajib_pajak' => 'nullable|boolean',
            'id_penunjukkan_perwakilan' => 'nullable|string',
            'npwp_perwakilan' => 'nullable|string',
            'nama_wakil' => 'nullable|string',
            'jenis_perwakilan' => 'nullable|string',
            'nomor_dokumen_penunjukkan_perwakilan' => 'nullable|string',
            'izin_perwakilan' => 'nullable|string',
            'status_penunjukkan' => 'nullable|string',
            'tanggal_disetujui' => 'nullable|date',
            'tanggal_ditolak' => 'nullable|date',
            'tanggal_dicabut' => 'nullable|date',
            'tanggal_dibatalkan' => 'nullable|date',
            'tanggal_tertunda' => 'nullable|date',
            'alasan' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
         ];
    }
}
<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest {
    public function rules(): array {
        return [
            'task_id' => 'required|integer|exists:tasks,id',
            'account_type_id' => 'required|integer|exists:account_types,id',
            'nama' => 'required|string',
            'npwp' => 'required|string|unique:accounts,npwp',
            'kegiatan_utama' => 'nullable|string',
            'jenis_wajib_pajak' => 'nullable|string',
            'kategori_wajib_pajak' => 'nullable|string',
            'status_npwp' => 'nullable|string',
            'tanggal_terdaftar' => 'nullable|datetime',
            'tanggal_aktivasi' => 'nullable|datetime',
            'status_pengusaha_kena_pajak' => 'nullable|string',
            'tanggal_pengukuhan_pkp' => 'nullable|datetime',
            'kantor_wilayah_direktorat_jenderal_pajak' => 'nullable|string',
            'kantor_pelayanan_pajak' => 'nullable|string',
            'seksi_pengawasan' => 'nullable|string',
            'tanggal_pembaruan_profil_terakhir' => 'nullable|datetime',
            'alamat_utama' => 'nullable|string',
            'nomor_handphone' => 'nullable|string',
            'email' => 'nullable|string',
            'kode_klasifikasi_lapangan_usaha' => 'nullable|string',
            'deskripsi_klasifikasi_lapangan_usaha' => 'nullable|string',
            // Add your validation rules here
        ];
    }
}

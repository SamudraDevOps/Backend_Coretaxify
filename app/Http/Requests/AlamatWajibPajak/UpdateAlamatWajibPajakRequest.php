<?php

namespace App\Http\Requests\AlamatWajibPajak;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlamatWajibPajakRequest extends FormRequest {
    public function rules(): array {
        return [
             
            'negara' => 'nullable|string',
            'jenis_alamat' => 'nullable|string',
            'detail_alamat' => 'nullable|string',
            'is_lokasi_disewa' => 'nullable|string',
            'npwp_pemilik_tempat_sewa' => 'nullable|string',
            'nama_pemilik_tempat_sewa' => 'nullable|string',
            'tanggal_mulai_sewa' => 'nullable|date',
            'tanggal_berakhir_sewa' => 'nullable|date',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_berakhir' => 'nullable|date',
            'kode_kpp' => 'nullable|string',
            'kpp' => 'nullable|string',
            'seksi_pengawasan' => 'nullable|string',
        ];
    }
}
<?php

namespace App\Http\Requests\DetailTransaksi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailTransaksiRequest extends FormRequest {
    public function rules(): array {
        return [
            'faktur_id' => 'required|integer',
            'tipe' => 'nullable|string',
            'nama' => 'nullable|string',
            'kode' => 'nullable|string',
            'kuantitas' => 'nullable|string',
            'satuan' => 'nullable|string',
            'harga_satuan' => 'nullable|numeric',
            'total_harga' => 'nullable|numeric',
            'pemotongan_harga' => 'nullable|numeric',
            'dpp' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'dpp_lain' => 'nullable|numeric',
            'ppnbm' => 'nullable|numeric',
            'ppn_retur' => 'nullable|numeric',
            'dpp_lain_retur' => 'nullable|numeric',
            'ppnbm_retur' => 'nullable|numeric',
            'tarif_ppnbm' => 'nullable|numeric',
        ];
    }
}

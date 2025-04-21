<?php

namespace App\Http\Requests\DetailTransaksi;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailTransaksiRequest extends FormRequest {
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
            'tarif_ppnbm' => 'nullable|numeric',
        ];
    }
}

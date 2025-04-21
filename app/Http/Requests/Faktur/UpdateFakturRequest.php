<?php

namespace App\Http\Requests\Faktur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFakturRequest extends FormRequest {
    public function rules(): array {
        return [
            'akun_penerima_id' => 'nullable|integer',
            'masa_pajak' => 'nullable|string',
            'tahun' => 'nullable|string',
            'status_faktur' => 'nullable|string',
            'esign_status' => 'nullable|string',
            'dpp_lain' => 'nullable|numeric',
            'dpp' => 'nullable|numeric',
            'ppn' => 'nullable|numeric',
            'ppnbm' => 'nullable|numeric',
            'penandatangan' => 'nullable|string',
            'referensi' => 'nullable|string',
            'kode_transaksi' => 'nullable|string',
            'informasi_tambahan' => 'nullable|string',
            'cap_fasilitas' => 'nullable|string',
            'dilaporkan_oleh_penjual' => 'nullable|boolean',
            'dilaporkan_oleh_pemungut_ppn' => 'nullable|boolean',
            'is_akun_tambahan' => 'nullable|boolean',
            'tanggal_faktur_pajak'=> 'nullable|date',

            'detail_transaksi' => 'nullable|array',
            'detail_transaksi.*.id' => 'nullable|integer',
            'detail_transaksi.*.tipe' => 'nullable|string',
            'detail_transaksi.*.nama' => 'nullable|string',
            'detail_transaksi.*.kode' => 'nullable|string',
            'detail_transaksi.*.kuantitas' => 'nullable|string',
            'detail_transaksi.*.satuan' => 'nullable|string',
            'detail_transaksi.*.harga_satuan' => 'nullable|numeric',
            'detail_transaksi.*.total_harga' => 'nullable|numeric',
            'detail_transaksi.*.pemotongan_harga' => 'nullable|numeric',
            'detail_transaksi.*.dpp' => 'nullable|numeric',
            'detail_transaksi.*.ppn' => 'nullable|numeric',
            'detail_transaksi.*.dpp_lain' => 'nullable|numeric',
            'detail_transaksi.*.ppnbm' => 'nullable|numeric',
            'detail_transaksi.*.tarif_ppnbm' => 'nullable|numeric',
        ];
    }
}

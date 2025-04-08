<?php

namespace App\Http\Requests\Faktur;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFakturRequest extends FormRequest {
    public function rules(): array {
        return [
            'akun_pengirim' => 'nullable|integer',
            'akun_penerima' => 'nullable|integer',
            'nomor_faktur_pajak' => 'nullable|string',
            'masa_pajak' => 'nullable|string',
            'tahun' => 'nullable|string',
            'status_faktur' => 'nullable|string',
            'esign_status' => 'nullable|string',
            'harga_jual' => 'nullable|decimal',
            'dpp_nilai_lain' => 'nullable|decimal',
            'ppn' => 'nullable|decimal',
            'ppnbm' => 'nullable|decimal',
            'penandatangan' => 'nullable|string',
            'referensi' => 'nullable|string',
            'informasi_tambahan' => 'nullable|string',
            'cap_fasilitas' => 'nullable|string',
            'dilaporkan_oleh_penjual' => 'nullable|boolean',
            'dilaporkan_oleh_pemungut_ppn' => 'nullable|boolean',
            'tanggal_faktur_pajak'=> 'nullable|date',
            'kode_transaksi_id' => 'nullable|integer',

            'detail_transaksi' => 'nullable|array',
            'detail_transaksi.*.tipe' => 'nullable|string',
            'detail_transaksi.*.nama' => 'nullable|string',
            'detail_transaksi.*.kode' => 'nullable|string',
            'detail_transaksi.*.kuantitas' => 'nullable|string',
            'detail_transaksi.*.satuan' => 'nullable|string',
            'detail_transaksi.*.harga_satuan' => 'nullable|string',
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

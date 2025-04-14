<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FakturResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'akun_pengirim_id' => new SistemResource($this->akun_pengirim),
            'akun_penerima_id' => new SistemResource($this->akun_penerima),
            'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
            'tahun' => $this->tahun,
            'status_faktur' => $this->status_faktur,
            'esign_status' => $this->esign_status,
            'dpp' => $this->dpp,
            'dpp_lain' => $this->dpp_lain,
            'ppn' => $this->ppn,
            'ppnbm' => $this->ppnbm,
            'penandatangan' => $this->penandatangan,
            'referensi' => $this->referensi,
            'kode_transaksi' => $this->kode_transaksi,
            'informasi_tambahan' => $this->informasi_tambahan,
            'cap_fasilitas' => $this->cap_fasilitas,
            'tanggal_faktur_pajak' => $this->tanggal_faktur_pajak,
            'dilaporkan_oleh_penjual' => $this->dilaporkan_oleh_penjual,
            'dilaporkan_oleh_pemungut_ppn' => $this->dilaporkan_oleh_pemungut_ppn,
            'is_draft' => $this->is_draft,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'detail_transaksis' => $this->whenLoaded('detail_transaksis', function() {
                return $this->detail_transaksis->map(function($transaksi) {
                    return [
                        'id' => $transaksi->id,
                        'tipe' => $transaksi->tipe,
                        'nama' => $transaksi->nama,
                        'kode' => $transaksi->kode,
                        'kuantitas' => $transaksi->kuantitas,
                        'satuan' => $transaksi->satuan,
                        'harga_satuan' => $transaksi->harga_satuan,
                        'total_harga' => $transaksi->total_harga,
                        'pemotongan_harga' => $transaksi->pemotongan_harga,
                        'dpp' => $transaksi->dpp,
                        'ppn' => $transaksi->ppn,
                        'dpp_lain' => $transaksi->dpp_lain,
                        'ppnbm' => $transaksi->ppnbm,
                        'tarif_ppnbm' => $transaksi->tarif_ppnbm,
                    ];
                });
            }),
        ];
    }
}

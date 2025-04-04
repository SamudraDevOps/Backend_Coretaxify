<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FakturResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'akun_pengirim' => new SistemResource($this->akun_pengirim),
            'akun_penerima' => new SistemResource($this->akun_penerima),
            'nomor_faktur_pajak' => $this->nomor_faktur_pajak,
            'masa_pajak' => $this->masa_pajak,
            'tahun' => $this->tahun,
            'status_faktur' => $this->status_faktur,
            'esign_status' => $this->esign_status,
            'harga_jual' => $this->harga_jual,
            'dpp_nilai_lain' => $this->dpp_nilai_lain,
            'ppn' => $this->ppn,
            'ppnbm' => $this->ppnbm,
            'penandatangan' => $this->penandatangan,
            'referensi' => $this->referensi,
            'dilaporkan_oleh_penjual ' => $this->dilaporkan_oleh_penjual,
            'dilaporkan_oleh_pemungut_ppn' => $this->dilaporkan_oleh_pemungut_ppn,
            'tanggal_faktur_pajak' => $this->tanggal_faktur_pajak,
            'kode_transaksi_id' => $this->kode_transaksi_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

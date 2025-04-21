<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailTransaksiResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'tipe' => $this->tipe,
            'nama' => $this->nama,
            'kode' => $this->kode,
            'kuantitas' => $this->kuantitas,
            'satuan' => $this->satuan,
            'harga_satuan' => $this->harga_satuan,
            'total_harga' => $this->total_harga,
            'pemotongan_harga' => $this->pemotongan_harga,
            'dpp' => $this->dpp,
            'ppn' => $this->ppn,
            'dpp_lain' => $this->dpp_lain,
            'ppnbm' => $this->ppnbm,
            'tarif_ppnbm' => $this->tarif_ppnbm,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
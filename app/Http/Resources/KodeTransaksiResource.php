<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KodeTransaksiResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'nama_transaksi' => $this->nama_transaksi,
            'jenis' => $this->jenis,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
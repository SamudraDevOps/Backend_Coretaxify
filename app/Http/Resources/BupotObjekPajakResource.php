<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BupotObjekPajakResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'tipe_bupot' => $this->tipe_bupot,
            'nama_objek_pajak' => $this->nama_objek_pajak,
            'jenis_pajak' => $this->jenis_pajak,
            'kode_objek_pajak' => $this->kode_objek_pajak,
            'tarif_pajak' => $this->tarif_pajak,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

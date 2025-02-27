<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NomorIdentifikasiEksternalResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'tipe_nomor_identifikasi' => $this->tipe_nomor_identifikasi,
            'nomor_identifikasi' => $this->nomor_identifikasi,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_berakhir' => $this->tanggal_berakhir,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TempatKegiatanUsahaResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'nitku' => $this->nitku,
            'jenis_tku' => $this->jenis_tku,
            'nama_tku' => $this->nama_tku,
            'jenis_usaha' => $this->jenis_usaha,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

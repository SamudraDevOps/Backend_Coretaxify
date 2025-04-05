<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SatuanResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'satuan' => $this->satuan,
            'jenis' => $this->jenis,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
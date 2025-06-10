<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KapKjsResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'ket_1' => $this->ket_1,
            'ket_2' => $this->ket_2,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

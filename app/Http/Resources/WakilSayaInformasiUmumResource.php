<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WakilSayaInformasiUmumResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'wakil_saya_id' => $this->wakil_saya_id,
            'informasi_umum_id' => $this->informasi_umum_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
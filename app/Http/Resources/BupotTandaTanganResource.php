<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BupotTandaTanganResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'jenis_penandatanganan' => $this->jenis_penandatanganan,
            'penyedia_penandatangan' => $this->penyedia_penandatangan,
            'id_penandatangan' => $this->id_penandatangan,
            'katasandi_penandatangan' => $this->katasandi_penandatangan,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

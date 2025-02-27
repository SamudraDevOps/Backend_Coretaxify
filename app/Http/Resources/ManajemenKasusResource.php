<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManajemenKasusResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'kanal' => $this->kanal,
            'tanggal_permohonan' => $this->tanggal_permohonan,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
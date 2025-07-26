<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'sistem_id' => $this->sistem_id,
            'pengirim' => $this->pengirim,
            'subjek' => $this->subjek,
            'isi' => $this->isi,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

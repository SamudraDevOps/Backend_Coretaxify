<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FakturScoreResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'sistem_id' => $this->sistem_id,
            'tipe_bupot' => $this->tipe_bupot,
            'score' => $this->score,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PicResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'akun_op' => new SistemResource($this->akun_op),
            'akun_badan' => new SistemResource($this->akun_badan),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

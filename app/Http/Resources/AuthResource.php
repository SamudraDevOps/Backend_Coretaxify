<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource  extends JsonResource {
    public function toArray($request) {
        return [
            'message' => $this->message ?? 'Operation successful',
            'data' => new UserResource($this->resource),
            'token' => $this->token,
            'token_type' => 'Bearer'
        ];
    }
}

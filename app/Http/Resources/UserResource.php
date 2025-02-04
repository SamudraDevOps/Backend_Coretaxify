<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->password,
            'contract_id' => $this->contract_id,
            'contract' => ContractResource::make($this->whenLoaded('contract')),
            'image_path' => $this->image_path,
            'unique_id' => $this->unique_id,
            'lecture_id' => $this->lecture_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
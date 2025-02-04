<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'role_id' => $this->role_id,
            'role' => RoleResource::make($this->whenLoaded('role')),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
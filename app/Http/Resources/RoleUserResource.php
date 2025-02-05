<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'users' => UserResource::collection($this->users),
            'role_id' => $this->role_id,
            'roles' => RoleResource::collection($this->roles),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
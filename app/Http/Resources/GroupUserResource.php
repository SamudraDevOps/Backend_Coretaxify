<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'users' => UserResource::collection($this->users),
            'group_id' => $this->group_id,
            'groups' => GroupResource::collection($this->groups),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
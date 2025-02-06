<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureTaskResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'users' => UserResource::collection($this->users),
            'group_id' => $this->group_id,
            // 'groups' => GroupResource::collection($this->groups),
            'name' => $this->name,
            'type' => $this->type,
            'start_at' => $this->start_at->toDateTimeString(),
            'end_at' => $this->end_at->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
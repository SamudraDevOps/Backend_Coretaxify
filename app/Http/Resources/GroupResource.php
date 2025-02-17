<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'class_code' => $this->class_code,
            'status' => $this->status,
            'filename' => $this->filename,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

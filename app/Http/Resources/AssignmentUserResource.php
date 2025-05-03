<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->user),
            // 'assignment_id' => $this->assignment_id,
            'assignment' => new AssignmentResource($this->assignment),
            'is_start' => $this->is_start,
            'score' => $this->score,
            'is_start' => $this->is_start,
            // 'created_at' => $this->created_at->toDateTimeString(),
            // 'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

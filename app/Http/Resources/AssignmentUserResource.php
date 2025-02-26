<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            // 'user' => UserResource::collection($this->user),
            'assignment_id' => $this->assignment_id,
            // 'assignment_id' => new AssignmentResource($this->assignment),
            'score' => $this->score,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
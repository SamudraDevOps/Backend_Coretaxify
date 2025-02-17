<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'group' => new GroupResource($this->whenLoaded('group')),
            'name' => $this->name,
            'assignment_code' => $this->assignment_code,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
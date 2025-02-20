<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'group' => new GroupResource($this->load('group')),
            'dosen' => $this->group->user,
            'name' => $this->name,
            'assignment_code' => $this->assignment_code,
            'task_id' => $this->task_id,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'supporting_file' => $this->supporting_file,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
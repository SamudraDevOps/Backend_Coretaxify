<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureTaskResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'group_id' => $this->group_id,
            'group' => GroupResource::collection($this->groups),
            'task_id' => $this->task_id,
            'task' => TaskResource::collection($this->tasks),
            'name' => $this->name,
            'type' => $this->type,
            'time' => $this->time,
            'task_code' => $this->task_code,
            'start_period' => $this->start_period,
            'end_period' => $this->end_period,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
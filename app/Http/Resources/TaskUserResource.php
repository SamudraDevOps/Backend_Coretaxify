<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'lecture_task_id' => $this->lecture_task_id,
            'lecture_tasks' => UserResource::collection($this->lecture_task),
            'task_id' => $this->task_id,
            'tasks' => TaskResource::collection($this->tasks),
            'score' => $this->score,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
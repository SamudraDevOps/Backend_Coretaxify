<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskUserResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'lecture_task_id' => $this->lecture_task_id,
            'lecture_task' => LectureTaskResource::make($this->whenLoaded('lecture_task')),
            'task_id' => $this->task_id,
            'task' => TaskResource::make($this->whenLoaded('task')),
            'score' => $this->score,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
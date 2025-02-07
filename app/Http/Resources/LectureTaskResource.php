<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LectureTaskResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => UserResource::collection($this->users),
            'task_id' => $this->task_id,
            'task' => GroupResource::collection($this->tasks),
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
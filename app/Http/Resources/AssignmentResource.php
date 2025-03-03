<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AssignmentResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'assignment_code' => $this->assignment_code,
            'group_id' => $this->group_id,
            'group' => new GroupResource($this->group),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'users_count' => count($this->users),
            'supporting_file' => $this->supporting_file,
            'task_id' => $this->task_id,
            'start_period' => $this->start_period ? Carbon::parse($this->start_period)->format('d-m-Y') : null,
            'end_period' => $this->end_period ? Carbon::parse($this->end_period)->format('d-m-Y') : null,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}

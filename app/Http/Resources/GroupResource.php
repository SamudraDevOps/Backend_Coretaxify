<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'teacher' => $this->user->name,
            'users_count' => count($this->users),
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
            'start_period' => $this->start_period ? Carbon::parse($this->start_period)->format('d-m-Y') : null,
            'end_period' => $this->end_period ? Carbon::parse($this->end_period)->format('d-m-Y') : null,
            'class_code' => $this->class_code,
            'status' => $this->status,
            // 'filename' => $this->filename,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'is_valid' => $this->isValid(),
        ];
    }
}

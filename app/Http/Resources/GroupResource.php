<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use App\Http\Resources\UserResource;
use App\Support\Enums\GroupStatusEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource {
    public function toArray($request): array {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'teacher' => $this->user->name,
            'users_count' => count($this->users),
            'assignments' => AssignmentResource::collection($this->whenLoaded('assignments')),
            'class_code' => $this->class_code,
            'status' => $this->status,
            // 'filename' => $this->filename,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];

        $user = $this->user;

        if ($user->hasAnyRole(['admin', 'psc', 'instruktur', 'mahasiswa-psc'])) {
            $data['valid'] = true;
        } else if (!empty($this->user->contract->end_period)) {
            $this->status == GroupStatusEnum::INACTIVE->value ? $data['valid'] = false : $data['valid'] = Carbon::parse($this->user->contract->end_period)->greaterThan(now());
        } else {
            $data['valid'] = true;
        }

        return $data;
    }
}
